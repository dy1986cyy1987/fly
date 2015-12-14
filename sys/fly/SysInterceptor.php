<?php
namespace fly\fly;

class SysInterceptor implements \fly\interfaces\InterceptorInterface
{

    /**
     *
     * {@inheritDoc}
     *
     * @see \fly\Interceptor::before()
     */
    public function before()
    {
        return \fly\interfaces\InterceptorInterface::STEP_CONTINUE;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \fly\Interceptor::after()
     */
    public function after()
    {
        return \fly\interfaces\InterceptorInterface::STEP_CONTINUE;
    }
}