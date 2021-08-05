        <section class="sidebar">
            <?php
            if(isset($menu_nav)){
                echo '<ul class="sidebar-menu" style="margin-bottom:130px;">'.$menu_nav.'</ul>';
            }elseif ($this->session->userdata('login_state') == "root") {
                
                $this->load->view('umum/rootnav_view');
                
            } else { 
                /*if(!isset($no_home)){?>
            <li><?php echo anchor($this->st['app']['direktori'].'/Home','<i class="fa fa-home"></i> <span>Beranda</span>') ?></li>
            <?php 
                }*/
                $id_peg = sesi('id_pegawai');
                $is_ref=(uri(1)=='referensi'?2:1);
                fget_nav($is_ref,!isset($no_home),"",0,(isset($uri_menu)?$uri_menu:""));
                /*if ($this->st['app']['direktori'] == 'referensi'){ cget_ref_nav($id_peg);}
                else{ cget_nav();}*//*($id_peg,1,($this->st['app']['id_aplikasi']?$this->st['app']['id_aplikasi']:0));}*/
            }
            ?>
        </section>