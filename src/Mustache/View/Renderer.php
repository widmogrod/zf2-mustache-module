<?php
namespace Mustache\View;

use Zend\View\Renderer\RendererInterface;
use Zend\View\Resolver\ResolverInterface;
use Zend\View\Model\ModelInterface;
use Mustache\Exception as Exception;

class Renderer implements RendererInterface
{
    /**
     * @var \Mustache_Engine
     */
    protected $engine;

    /**
     * @var ResolverInterface
     */
    protected $resolver;

    /**
     * @var bool
     */
    protected $suffixLocked;

    /**
     * @var string
     */
    protected $suffix;

    public function setEngine(\Mustache_Engine $engine)
    {
        $this->engine = $engine;
    }

    /**
     * Return the template engine object, if any
     *
     * If using a third-party template engine, such as Smarty, patTemplate,
     * phplib, etc, return the template engine object. Useful for calling
     * methods on these objects, such as for setting filters, modifiers, etc.
     *
     * @return \Mustache_Engine
     */
    public function getEngine()
    {
        if (null === $this->engine) {
            $this->engine = new \Mustache_Engine();
        }
        return $this->engine;
    }

    /**
     * Set the resolver used to map a template name to a resource the renderer may consume.
     *
     * @param  ResolverInterface $resolver
     * @return RendererInterface
     */
    public function setResolver(ResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * Processes a view script and returns the output.
     *
     * @param  string|ModelInterface   $nameOrModel The script/resource process, or a view model
     * @param  null|array|\ArrayAccess $values      Values to use during rendering
     * @return string The script output.
     */
    public function render($nameOrModel, $values = null)
    {
        if ($nameOrModel instanceof ModelInterface) {
            $model       = $nameOrModel;
            $nameOrModel = $model->getTemplate();

            if (empty($nameOrModel)) {
                throw new Exception\DomainException(sprintf(
                    '%s: received View Model argument, but template is empty',
                    __METHOD__
                ));
            }

            $values = $model->getVariables();
            unset($model);
        }

        if (!($file = $this->resolver->resolve($nameOrModel))) {
            throw new \Exception(sprintf('Unable to find template "%s".', $nameOrModel));
        }

        $mustache = $this->getEngine();
        return $mustache->render(
            file_get_contents($file),
            $values
        );
    }

    /**
     * @param $nameOrModel
     */
    public function canRender($nameOrModel)
    {
        if ($nameOrModel instanceof ModelInterface) {
            $nameOrModel = $nameOrModel->getTemplate();
        }

        if (!$this->getSuffixLocked()) {
            return true;
        }

        $tpl = $this->resolver->resolve($nameOrModel);
        $ext = pathinfo($tpl, PATHINFO_EXTENSION);

        if ($tpl && $ext == $this->getSuffix()) {
            return true;
        }

        return false;
    }

    /**
     * @param string $suffix
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
    }

    /**
     * @return string
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * @param boolean $suffixLocked
     */
    public function setSuffixLocked($suffixLocked)
    {
        $this->suffixLocked = $suffixLocked;
    }

    /**
     * @return boolean
     */
    public function getSuffixLocked()
    {
        return $this->suffixLocked;
    }
}