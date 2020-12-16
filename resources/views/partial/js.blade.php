	<!-- Required Vendor -->
	<script src="{{ url('assets/vendor/global/global.min.js') }}"></script>
	<script src="{{ url('assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ url('assets/vendor/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ url('assets/js-/custom.min.js') }}"></script>
	<script src="{{ url('assets/js-/deznav-init.js') }}"></script>
	<!-- Apex Chart -->
	<script src="{{ url('assets/vendor/apexchart/apexchart.js') }}"></script>
	
    <!-- Vectormap -->
	<!-- Chart piety plugin files -->
    <script src="{{ url('assets/vendor/peity/jquery.peity.min.js') }}"></script>
	
    <!-- Chartist -->
    <script src="{{ url('assets/vendor/chartist/js/chartist.min.js') }}"></script>
	
	<!-- Dashboard 1 -->
	<script src="{{ url('assets/js-/dashboard/dashboard-1.js') }}"></script>
	<!-- Svganimation scripts -->
	<script src="{{ url('assets/vendor/svganimation/vivus.min.js') }}"></script>
	<script src="{{ url('assets/vendor/svganimation/svg.animation.js') }}"></script>

    <!-- Datatable -->
    <script src="{{ url('assets/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ url('assets/js-/plugins-init/datatables.init.js') }}"></script>
	
	{{-- <script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script> --}}

	<!-- Daterangepicker -->
    <!-- momment js is must -->
    <script src="{{ url('assets/vendor/moment/moment.min.js') }}"></script>
    <script src="{{ url('assets/vendor/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- clockpicker -->
    <script src="{{ url('assets/vendor/clockpicker/js/bootstrap-clockpicker.min.js') }}"></script>
    <!-- asColorPicker -->
    <script src="{{ url('assets/vendor/jquery-asColor/jquery-asColor.min.js') }}"></script>
    <script src="{{ url('assets/vendor/jquery-asGradient/jquery-asGradient.min.js') }}"></script>
    <script src="{{ url('assets/vendor/jquery-asColorPicker/js/jquery-asColorPicker.min.js') }}"></script>
    <!-- Material color picker -->
    <script src="{{ url('assets/vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
    <!-- pickdate -->
    <script src="{{ url('assets/vendor/pickadate/picker.js') }}"></script>
    <script src="{{ url('assets/vendor/pickadate/picker.time.js') }}"></script>
    <script src="{{ url('assets/vendor/pickadate/picker.date.js') }}"></script>



    <!-- Daterangepicker -->
    <script src="{{ url('assets/js-/plugins-init/bs-daterange-picker-init.js') }}"></script>
    <!-- Clockpicker init -->
    <script src="{{ url('assets/js-/plugins-init/clock-picker-init.js') }}"></script>
    <!-- asColorPicker init -->
    <script src="{{ url('assets/js-/plugins-init/jquery-asColorPicker.init.js') }}"></script>
    <!-- Material color picker init -->
    <script src="{{ url('assets/js-/plugins-init/material-date-picker-init.js') }}"></script>
    <!-- Pickdate -->
    <script src="{{ url('assets/js-/plugins-init/pickadate-init.js') }}"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    
    <script>
        (function($) {
            "use strict"
    
            var direction =  getUrlParams('dir');
            if(direction != 'rtl')
            {direction = 'ltr'; }
            
            new dezSettings({
                typography: "roboto",
                version: "light",
                layout: "vertical",
                headerBg: "color_1",
                navheaderBg: "color_3",
                sidebarBg: "color_1",
                sidebarStyle: "full",
                sidebarPosition: "fixed",
                headerPosition: "fixed",
                containerLayout: "wide",
                direction: direction
            }); 
    
        })(jQuery);	
    </script>

