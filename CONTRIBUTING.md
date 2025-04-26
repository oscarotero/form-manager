# Contributing Guide

This project adheres to [The Code Manifesto](http://codemanifesto.com) as its guidelines for contributor interactions.

## The Code Manifesto

We want to work in an ecosystem that empowers developers to reach their potential--one that encourages growth and effective collaboration. A space that is safe for all.

A space such as this benefits everyone that participates in it. It encourages new developers to enter our field. It is through discussion and collaboration that we grow, and through growth that we improve.

In the effort to create such a place, we hold to these values:

1. **Discrimination limits us.** This includes discrimination on the basis of race, gender, sexual orientation, gender identity, age, nationality, technology and any other arbitrary exclusion of a group of people.
2. **Boundaries honor us.** Your comfort levels are not everyone’s comfort levels. Remember that, and if brought to your attention, heed it.
3. **We are our biggest assets.** None of us were born masters of our trade. Each of us has been helped along the way. Return that favor, when and where you can.
4. **We are resources for the future.** As an extension of #3, share what you know. Make yourself a resource to help those that come after you.
5. **Respect defines us.** Treat others as you wish to be treated. Make your discussions, criticisms and debates from a position of respectfulness. Ask yourself, is it true? Is it necessary? Is it constructive? Anything less is unacceptable.
6. **Reactions require grace.** Angry responses are valid, but abusive language and vindictive actions are toxic. When something happens that offends you, handle it assertively, but be respectful. Escalate reasonably, and try to allow the offender an opportunity to explain themselves, and possibly correct the issue.
7. **Opinions are just that: opinions.** Each and every one of us, due to our background and upbringing, have varying opinions. That is perfectly acceptable. Remember this: if you respect your own opinions, you should respect the opinions of others.
8. **To err is human.** You might not intend it, but mistakes do happen and contribute to build experience. Tolerate honest mistakes, and don't hesitate to apologize if you make one yourself.

## How to contribute

This is a collaborative effort. We welcome all contributions submitted as pull requests.

(Contributions on wording & style are also welcome.)

### Bugs

A bug is a demonstrable problem that is caused by the code in the repository. Good bug reports are extremely helpful – thank you!

Please try to be as detailed as possible in your report. Include specific information about the environment – version of PHP, etc, and steps required to reproduce the issue.

### Pull Requests

Good pull requests – patches, improvements, new features – are a fantastic help. Before create a pull request, please follow these instructions:

* The code must follow the [PSR-2 Coding Standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md). Run `composer cs-fix` to fix your code before commit.
* Write tests
* Document any change in `README.md` and `CHANGELOG.md`
* One pull request per feature. If you want to do more than one thing, send multiple pull request

### Runing tests

```sh
composer test
```

To get code coverage information execute the following comand:

```sh
composer coverage
```

Then, open the `./coverage/index.html` file in your browser.
