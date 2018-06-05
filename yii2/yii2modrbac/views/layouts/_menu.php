<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
$items = [
    [
        'label' => 'rbac',
        'items' => [
            ['label' => 'Route', 'url' => ['/rbac/route']],
            ['label' => 'Permission', 'url' => ['/rbac/permission']],
            ['label' => 'Role', 'url' => ['/rbac/role']],
            ['label' => 'Assignment', 'url' => ['/rbac/assignment']],
        ],
    ],
    [
        'label' => 'user',
        'items' => [
            ['label' => 'Login', 'url' => ['/site/login']],
            ['label' => 'Logout', 'url' => ['/site/logout']],
            ['label' => 'Signup', 'url' => ['/site/signup']],
            ['label' => 'RequestPasswordReset', 'url' => ['/site/request-password-reset']],
            ['label' => 'PasswordReset', 'url' => ['/site/password-reset']],

        ],
    ],
];
if (Yii::$app->user->isGuest) {
    $items[] = ['label' => 'Login', 'url' => ['/site/login']];
} else {
    $items[] = '<li>'
        . Html::beginForm(['/site/logout'], 'post')
        . Html::submitButton(
            'Logout (' . Yii::$app->user->identity->username . ')',
            ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $items,
]);
NavBar::end();
