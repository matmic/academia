<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Alert;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AcademiaAsset;

AcademiaAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <style>#loader{transition:all .3s ease-in-out;opacity:1;visibility:visible;position:fixed;height:100vh;width:100%;background:#fff;z-index:90000}#loader.fadeOut{opacity:0;visibility:hidden}.spinner{width:40px;height:40px;position:absolute;top:calc(50% - 20px);left:calc(50% - 20px);background-color:#333;border-radius:100%;-webkit-animation:sk-scaleout 1s infinite ease-in-out;animation:sk-scaleout 1s infinite ease-in-out}@-webkit-keyframes sk-scaleout{0%{-webkit-transform:scale(0)}100%{-webkit-transform:scale(1);opacity:0}}@keyframes sk-scaleout{0%{-webkit-transform:scale(0);transform:scale(0)}100%{-webkit-transform:scale(1);transform:scale(1);opacity:0}}</style>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="app">
    <?php $this->beginBody() ?>
    <div id="loader">
        <div class="spinner">
        </div>
    </div>
    <script>
        window.addEventListener('load', () => {
            const loader = document.getElementById('loader');
            setTimeout(() => {
                loader.classList.add('fadeOut');
            }, 300);
        });
    </script>
    <div>
        <div class="sidebar">
            <div class="sidebar-inner">
                <div class="sidebar-logo">
                    <div class="peers ai-c fxw-nw">
                        <div class="peer peer-greed">
                            <a class="sidebar-link td-n" href="<?=Yii::$app->homeUrl; ?>">
                                <div class="peers ai-c fxw-nw">
                                    <div class="peer">
                                        <div class="logo"></div>
                                    </div>
                                    <div class="peer peer-greed">
                                        <h5 class="lh-1 mB-0 logo-text">Academia</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="peer">
                            <div class="mobile-toggle sidebar-toggle"><a href="" class="td-n"><i class="ti-arrow-circle-left"></i></a></div>
                        </div>
                    </div>
                </div>
                <ul class="sidebar-menu scrollable pos-r">
                    <li class="nav-item"><a class="sidebar-link" href="<?= Url::to(['professor/meus-alunos'], true); ?>"><span class="icon-holder"><i class="c-black-500 ti-agenda"></i> </span><span class="title">Meus Alunos</span></a></li>
                    <li class="nav-item"><a class="sidebar-link" href="<?= Url::to(['treino/listar'], true); ?>"><span class="icon-holder"><i class="c-black-500 ti-notepad"></i> </span><span class="title">Treinos</span></a></li>
                    <li class="nav-item"><a class="sidebar-link" href="<?= Url::to(['professor/listar'], true); ?>"><span class="icon-holder"><i class="c-black-500 ti-user"></i> </span><span class="title">Professores</span></a></li>
                    <li class="nav-item"><a class="sidebar-link" href="<?= Url::to(['aluno/listar'], true); ?>"><span class="icon-holder"><i class="c-black-500 ti-user"></i> </span><span class="title">Alunos</span></a></li>
                    <li class="nav-item"><a class="sidebar-link" href="<?= Url::to(['aparelho/listar'], true); ?>"><span class="icon-holder"><i class="c-black-500 ti-split-v"></i> </span><span class="title">Aparelhos</span></a></li>
                    <li class="nav-item"><a class="sidebar-link" href="<?= Url::to(['grupo/listar'], true); ?>"><span class="icon-holder"><i class="c-black-500 ti-package"></i> </span><span class="title">Grupos</span></a></li>
                </ul>
            </div>
        </div>
        <div class="page-container">
            <div class="header navbar">
                <div class="header-container">
                    <ul class="nav-left">
                        <li><a id="sidebar-toggle" class="sidebar-toggle" href="javascript:void(0);"><i class="ti-menu"></i></a></li>
                        <li class="search-input"><input class="form-control" type="text" placeholder="Search..."></li>
                    </ul>
                    <ul class="nav-right">
                        <li class="dropdown">
								<span style="min-height: 65px;" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1">
									<div class="peer">
										<span class="fsz-sm c-grey-900">
											<?php
                                            if (Yii::$app->user->isGuest) {
                                                echo '<a href="' . Url::to(['professor/login'], true) . '"><span class="icon-holder botaoLoginLogout"><i class="c-red-500 fa fa-sign-in fa-fw"></i></span></a>';
                                            } else {
                                                echo '<a data-method="post" href="' . Url::to(['professor/logout'], true) . '"><span class="icon-holder botaoLoginLogout"><i class="c-red-500 fa fa-sign-out fa-fw"></i></span></a>';
                                            }
                                            ?>
										</span>
									</div>
								</span>
                        </li>
                    </ul>
                </div>
            </div>
            <main class="main-content bgc-grey-100">
                <div id="mainContent">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                                <?= Breadcrumbs::widget([
                                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                ]) ?>
                                <?= Alert::widget() ?>
                                <?= $content ?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="footer bdT ta-c p-30 lh-0 fsz-sm c-grey-600">
					<span>
						Academia XYZ! Entre em contato: <a href="http://www.ufrgs.br/" target="_blank" title="Academia">Academia</a> - Avenida lalala
						<a href="hahaha">Envie um e-mail!</a>
					</span>
            </footer>
        </div>
    </div>
    <script type="text/javascript" src="<?= Yii::$app->homeUrl; ?>js/vendor.js"></script>
    <script type="text/javascript" src="<?= Yii::$app->homeUrl; ?>js/bundle.js"></script>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>