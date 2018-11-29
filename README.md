Installation
============

> **NOTE:** The bundle is compatible with Symfony `3.0` upwards.

1 . Download this bundle to your project first. The preferred way to do it is
    to use [Composer](https://getcomposer.org/) package manager:

``` json
"require": {
    "inem0o/user-password-lost-bundle": "dev-master"
}
```

2 . Configure kernel:

``` php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new inem0o\UserPasswordLostBundle\UserPasswordLostBundle(),
        // ...
    );
}
```


3 . Configure bundle :

``` yaml
# app/config/config.yml
  user_password_lost:
      user_repo_name: "AppBundle:User"
      user_email_column_name: "email"

      email_from: "contact@site.net"

      route_to_redirect_on_failure: "homepage"
      route_to_redirect_on_success: "login"

      display_success_flashbag: true

      forms:
            constraints:
                    - {form_name: form_password_request, field: user_email, class: Symfony\Component\Validator\Constraints\NotBlank, params: {message: 'Email field cannot be blank'}}

```

4 . Configure routes :
``` yaml
# app/config/routing.yml
user_password_lost:
  resource: "@UserPasswordLostBundle/Resources/config/routing.yml"
  prefix:   /
```

4 . Override templates :

    Copy all templates from

    ./vendor/inem0o/user-password-lost-bundle/inem0o/UserPasswordLostBundle/Resources/views/*

    into the folder

    ./app/Resources/UserPasswordLostBundle/views

5 . Override translations :

    Copy all translation files from

    ./vendor/inem0o/user-password-lost-bundle/inem0o/UserPasswordLostBundle/Resources/translations/userPasswordLostBundle.*.xliff

    into the folder

    ./app/Resources/translations/userPasswordLostBundle.*.xliff


## Events

The UserPasswordLostBundle dispatches an event when the reset has been successful : ```inem0o.userpasswordlostbundle.successful_reset```
The event contains the user who requested a new password, accessible with a ```$event->getUser()``` getter.
You have to register a listener in order to catch it.

Example :
(Considering you named your event **PasswordResetSuccessListener** and your callback method **onSuccessfulReset**)
``` yaml
# src/Acme/AppBundle/Resources/config/services.yml
acme.user.reset_password_success.listener:
        class: Acme\AppBundle\EventListener\PasswordResetSuccessListener
        tags:
          - { name: kernel.event_listener, event: inem0o.userpasswordlostbundle.successful_reset, method: onSuccessfulReset }
```
