<?php
use yii\helpers\Html;
$this->title = $name;
?>
<div class="site-error">
    <div class="st-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="primary" class="content-area padding-content white-color">
                        <main id="main" class="site-main" role="main">

                            <section class="error-404 not-found text-center">
                                <h2 class=""><?= Html::encode($this->title) ?></h2>

                                <p class="lead">Sorry, we could not found the page you are looking for!</p>

                                <div class="row">
                                    <div class="col-sm-4 col-sm-offset-4">

                                        <p class="go-back-home"><a href="<?php echo Yii::getAlias('@web/').'site/index'?>">
                                                Back to Home Page</a></p>
                                    </div>
                                </div>

                            </section><!-- .error-404 -->

                        </main><!-- #main -->
                    </div><!-- #primary -->
                </div>
            </div>
        </div>
    </div>
