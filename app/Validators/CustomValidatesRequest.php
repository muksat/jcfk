<?php

namespace Jcfk\Validators;


use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

trait CustomValidatesRequest
{
    /**
     * @param AbstractValidator $validator
     * @param Request $request
     */
    public function validate(Request $request, AbstractValidator $validator)
    {
        if (!$validator->validate($request->all())) {
            $this->throwValidationException($request, $validator);
        }
    }

    /**
     * @param AbstractValidator $validator
     * @param Request $request
     */
    protected function throwValidationException(Request $request, AbstractValidator $validator)
    {
        throw new HttpResponseException($this->buildFailedValidationResponse(
            $request, $this->formatValidationErrors($validator)
        ));
    }

    /**
     * Create the response for when a request fails validation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $errors
     * @return \Illuminate\Http\Response
     */
    protected function buildFailedValidationResponse(Request $request, array $errors)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return new JsonResponse($errors, 422);
        }

        return redirect()->to($this->getRedirectUrl())
            ->withInput($request->input())
            ->withErrors($errors, $this->errorBag());
    }

    protected function formatValidationErrors(AbstractValidator $validator)
    {
        return $validator->errors()->all();
    }

    /**
     * Get the URL we should redirect to.
     *
     * @return string
     */
    protected function getRedirectUrl()
    {
        return app('Illuminate\Routing\UrlGenerator')->previous();
    }

    /**
     * Get a validation factory instance.
     *
     * @return \Illuminate\Contracts\Validation\Factory
     */
    protected function getValidationFactory()
    {
        return app('Illuminate\Contracts\Validation\Factory');
    }

    /**
     * Get the key to be used for the view error bag.
     *
     * @return string
     */
    protected function errorBag()
    {
        return 'default';
    }
}