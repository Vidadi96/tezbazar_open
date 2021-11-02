<footer class="m-grid__item		m-footer ">
  <div class="m-container m-container--fluid m-container--full-height m-page__container">
    <div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
      <div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
        <span class="m-footer__copyright">
          2020 &copy; Tezbazar.evv.az
        </span>
      </div>
    </div>
  </div>
</footer>
<!-- end::Footer -->
</div>
<!-- end:: Page -->
<!-- begin::Scroll Top -->
<div id="m_scroll_top" class="m-scroll-top">
<i class="la la-arrow-up"></i>
</div>
<!-- end::Scroll Top -->

<!--begin::Page Vendors -->
<script src="/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>
<!--end::Page Vendors -->
<!--begin::Page Snippets -->
<script src="/assets/demo/default/base/custom.js" type="text/javascript"></script>
<?php if ($title == 'users/waiting'): ?>
  <script src="/assets/adminPanel/js/waiting.js" type="text/javascript"></script>
<?php endif; ?>

<!--end::Page Snippets -->
<!-- Delete Modal -->
<div class="modal fade delete_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
  <div class="modal-content">
  	<div class="modal-header">
      <h5 class="modal-title" id="mySmallModalLabel"><i class="fa fa-exclamation-triangle m--font-danger"></i> Məlumatın silinməsi</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
  	</div>
  	<div class="modal-body">
  		Məlumatı silmək istədiyinizə əminsiniz?
  	</div>
  	<div class="modal-footer">
  		<button type="button" class="btn btn-info delete-cancel" data-dismiss="modal">İmtina</button>
  		<button type="button" class="btn btn-danger delete-accept">Sil</button>
  	</div>
  </div>
  </div>
</div>
<!-- /Delete Modal -->

</body>
<!-- end::Body -->
</html>
