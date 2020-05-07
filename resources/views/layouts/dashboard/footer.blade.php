<div class="kt-footer  kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop" id="kt_footer">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-footer__copyright" style="margin:auto">
            <!--2020&nbsp;&copy;&nbsp;-->
            <a href="https://www.yardimeli.org.ps" target="_blank" class="kt-link">
                @php
                    $footer = \App\Setting::where('key', 'footer')->first();
                @endphp
                {{ !is_null($footer) ? $footer->value : '' }}
            </a>
            
            <a href="https://www.yardimeli.org.ps" target="_blank" class="kt-link">                
            &nbsp;©&nbsp;2020 &nbsp;&nbsp;&nbsp;&nbsp;|| &nbsp;

          <a href="https://www.hams.ps" target="_blank" class="kt-link"> <b> &nbsp;&nbsp; HTC &nbsp;</b> </a> POWERED BY  
        
        </div>
    </div>
</div>
