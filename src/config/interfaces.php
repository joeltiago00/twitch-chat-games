<?php

return [
    \Repositories\Duel\DuelRepository::class => \Repositories\Duel\DuelEloquentRepository::class,
    \Repositories\Answer\AnswerRepository::class => \Repositories\Answer\AnswerEloquentRepository::class,
    \Repositories\DuelAnswer\DuelAnswerRepository::class => \Repositories\DuelAnswer\DuelAnswerEloquentRepository::class,
    \Repositories\User\UserRepository::class => \Repositories\User\UserEloquentRepository::class
];
