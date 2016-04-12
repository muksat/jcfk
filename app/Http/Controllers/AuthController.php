<?php

namespace Jcfk\Http\Controllers;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Post;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Jcfk\Models\Role;
use Jcfk\Models\User;
use Jcfk\Validators\AuthValidator;
use Jcfk\Validators\CustomValidatesRequest;
use Jcfk\Validators\ParentValidator;
use Jcfk\Validators\UserValidator;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Middleware("guest", except={"logout"})
 */
class AuthController extends BaseController
{
    use CustomValidatesRequest, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth, Registrar $registrar)
    {
        $this->auth      = $auth;
        $this->registrar = $registrar;
    }

    /**
     * Handle a login request to the application.
     * @Post("auth", as="auth")
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function auth(Request $request, AuthValidator $authValidator)
    {
        $this->validate($request, $authValidator);

        if ($this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $request->only('email', 'password');

        if ($this->auth->attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $this->auth->user());
        }

        $this->incrementLoginAttempts($request);

        return redirect()
            ->route('homepage')
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'These credentials do not match our records.'
            ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @Get("logout", as="logout")
     * @Middleware("auth")
     */
    public function logout()
    {
        $this->auth->logout();

        return redirect()->route('homepage');
    }

    /**
     * @Get("register", as="register")
     * @return \Illuminate\View\View
     */
    public function registrationForm()
    {
        return view('register');
    }

    /**
     * @Post("register", as="register")
     * @param Request $request
     * @param UserValidator $userValidator
     * @param ParentValidator $parentValidator
     */
    public function register(Request $request, ParentValidator $parentValidator, User $user)
    {
        $this->validate($request, $parentValidator);

        $user = $user->register($request, Role::PARENT);

        $user->parent()->create($request->all());

        $this->auth->login($user);

        return redirect()
            ->route('parent::dashboard');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return 'email';
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    private function handleUserWasAuthenticated(Request $request, User $user)
    {
        $this->clearLoginAttempts($request);

        return redirect()->intended($user->getAuthDefaultPath());
    }
}
