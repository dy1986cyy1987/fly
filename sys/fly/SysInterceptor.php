<?php
namespace fly\fly;

use \fly\interfaces as f_faces;

class SysInterceptor implements f_faces\InterceptorInterface
{

    /**
     *
     * {@inheritDoc}
     *
     * @see \fly\Interceptor::before()
     */
    public function before()
    {
        return f_faces\InterceptorInterface::STEP_CONTINUE;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \fly\Interceptor::after()
     */
    public function after()
    {
        return f_faces\InterceptorInterface::STEP_CONTINUE;
    }
}