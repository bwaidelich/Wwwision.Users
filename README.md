# Wwwision.Users

Simple (and WIP) package demonstrating/testing features of the Neos.Cqrs package

## Setup

1. Install via git or composer
2. Make sure that the Neos.Cqrs package (including https://github.com/neos/Neos.Cqrs/pull/62/files) is installed
3. head your browser to http://localhost/users

Via "Sign up" you can register new users.
If you "sign in" you should be able to rename the user with the same username

## Features

### Integration of 3rd party services

The package comes with a (very simple) [AccountService](Classes/Domain/Service/AccountService.php) that demonstrates/tests how event-sourced systems can interact with other APIs.

### Commands with sensitive data

By hashing the password already in the [command](Classes/Domain/Aggregate/User/Command/SignUpUser.php) we minimize leakage (idea by Robert Lemke)

### Logging commands

With a simple [AOP Aspect](Classes/Application/Service/CommandLoggerAspect.php) we log calls to all command handlers - demonstrating that we don't need a `CommandBus` to intercept these

### CLI interaction

A [CommandController](Classes/Application/Command/UserCommandController.php) deminstrates interaction with aggregates from CLI

### Policy with runtime evaluations

The aggregate is the API. The provided [policy](https://github.com/bwaidelich/Wwwision.Users/blob/master/Configuration/Policy.yaml#L6) shows how we can intercept calls to `User::rename()` to be only allowed by the "owner" & administrators.
A corresponding [ViewHelper](Classes/Application/ViewHelpers/Security/CanRenameUserViewHelper.php) demonstrates how this can be tested proactively.

### Optimistic locking

By copying the event stream version to the Read Model, we can detect outdated aggregates:
Try changing the same user from two browser windows without reloading and you'll see an error.
*Note* Currently we just catch the exception and display an error in the controller
