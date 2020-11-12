<?php

declare(strict_types = 1);

/**
 *
 * This file is part of DarkMatter for PHP.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 *
 */
namespace DarkMatter\View;

/**
 *
 * A concrete TemplateView/TwoStepView pattern implementation.
 *
 * @package DarkMatter.View
 *
 */
class View extends AbstractView
{
    /**
     *
     * Returns the rendered view along with any specified layout.
     *
     * @return string
     *
     */
    public function __invoke()
    {
        $this->setTemplateRegistry($this->getViewRegistry());
        $this->setContent($this->render($this->getView()));

        $layout = $this->getLayout();
        if (! $layout) {
            return $this->getContent();
        }

        $this->setTemplateRegistry($this->getLayoutRegistry());
        return $this->render($layout);
    }

    /**
     *
     * Renders a template from the current template registry using output
     * buffering.
     *
     * @param string $name The name of the template to be rendered.
     *
     * @param array $vars Variables to `extract()` within the view as local
     * variables. Closure-based templates will need to call `extract()` on
     * their own.
     *
     * @return string
     *
     */
    protected function render($name, array $vars = []) : string
    {
        ob_start();
        $this->getTemplate($name)->__invoke($vars);
        return ob_get_clean();
    }
}
