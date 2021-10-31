
  <main role="main" class="inner cover">

<div class="title px-3 py-3">
  <h1 class="text-center">Instagram Photo and Video Downloader</h1>
</div>

<center>
  <div class="container"> 
  <label><?php language('_PLACEHOLDER3'); ?></label>
                        <input type="url" id="input" name="input" class="form-control" placeholder="<?php language('_PLACEHOLDER3'); ?>">
                        <input type="hidden" name="action" id="action" value="profilePic">
                        <input type="hidden" name="json" id="json" value="">
                        <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']; ?>">
                        <button id="btnDownloadProfilePhoto" class="btn btn-default btn-block mt-3">
                            <i class="fas fa-download"></i> <?php language('_DOWNLOAD'); ?>
                        </button>
</center>


    <section id="downloadArea" class="section section-sm bg-gradient-white">
        <div class="container pt-sm-0 ">
            <div class="row text-center justify-content-center">
                <div class="col-lg-10" id="infoBox"></div>
            </div>
            <div class="row row-grid mt-5">
                <div class="col-lg-2" id="posterInfo"></div>
                <div class="col-lg-10">
                    <div class="row" id="downloadLinks"></div>
                </div>
            </div>
        </div>
    </section>
</main>