
  <main role="main" class="inner cover">

<div class="title px-3 py-3">
  <h1 class="text-center">Instagram Stories Downloader</h1>
</div>

<center>
  <div class="container"> 
    <p id="blank_url" style="color: red; display: none;">*Enter your Photo/Video URL*</p>
    <label><?php language('_PLACEHOLDER2'); ?></label>
                        <input type="url" id="input" name="input" class="form-control" placeholder="<?php language('_PLACEHOLDER2'); ?>">
                        <input type="hidden" name="action" id="action" value="story">
                        <input type="hidden" name="json" id="json" value="">
                        <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']; ?>">
                        <button id="btnDownloadStory" class="btn btn-default btn-block mt-3">
                            <i class="fas fa-download"></i> <?php language('_DOWNLOAD'); ?>
                        </button>


    <section style="display:none" class="output">
    </section>
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