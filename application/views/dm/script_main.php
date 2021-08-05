<script type="text/javascript">
    function varian(hex, lum) {

        // validate hex string
        hex = String(hex).replace(/[^0-9a-f]/gi, '');
        if (hex.length < 6) {
            hex = hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];
        }
        lum = lum || 0;
    
        // convert to decimal and change luminosity
        var rgb = "#", c, i;
        for (i = 0; i < 3; i++) {
            c = parseInt(hex.substr(i*2,2), 16);
            c = Math.round(Math.min(Math.max(0, c + (c * lum)), 255)).toString(16);
            rgb += ("00"+c).substr(c.length);
        }
    
        return rgb;
    }
    <?php 
        $maincolor='#4666a6';
        if(!empty($this->st['main_color']))$maincolor=$this->st['main_color'];
    ?>
    $(document).ready(function() {
        $('.skin-blue .sidebar-menu > li.active > a').css('border-left-color',varian('<?php echo $maincolor ?>',0.2));    
        $('.skin-blue .main-header .navbar').css('background-color','<?php echo $maincolor ?>');
        $('.skin-blue .main-header .logo ').css('background-color',varian('<?php echo $maincolor ?>',-0.3)); 
        var sbar=getCookie('sbar');
        if(sbar==1){
            $('body').addClass('sidebar-collapse');
                console.log('sbar 01 : '+ getCookie('sbar'));
        }else{
            $('body').removeClass('sidebar-collapse');
                console.log('sbar 02 : '+ getCookie('sbar'));
        }
        $('.sidebar-toggle').click(function(){
            if(sbar==1){
                setCookie('sbar',0,1);
                console.log('sbar : '+ getCookie('sbar'));
            }else{
                setCookie('sbar',1,1);
                console.log('sbar : '+ getCookie('sbar'));
            }
        });
    });
    <?php 
        if(!empty($script_cookies)){
    ?>
    function getCookie(c_name){
        if (document.cookie.length>0){
            c_start=document.cookie.indexOf(c_name + "=");
            if (c_start!=-1){
                c_start=c_start + c_name.length+1;
                c_end=document.cookie.indexOf(";",c_start);
            if (c_end==-1) c_end=document.cookie.length;
                return unescape(document.cookie.substring(c_start,c_end));
            }
        }
        return "";
    }

    function setCookie(c_name,value,expiredays){
        var exdate=new Date();
        exdate.setDate(exdate.getDate()+expiredays);
        document.cookie=c_name+ "=" +escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
    }

    function checkCookie(){
        waktuy=getCookie("waktux");
        if (waktuy!=null && waktuy!=""){
            waktu = waktuy;
        }else{
            waktu = waktunya;
            setCookie("waktux",waktunya,7);
        }
    }
    <?php 
        }
    ?>
</script>