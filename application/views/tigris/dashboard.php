<h3 style="margin-top: 0px;">Selamat Datang di Online Thesis Registration</h3>
<div class="row">
          <div class="col-lg-9 col-xs-12" style="padding:0">
            <div class="col-xs-12">
              <div class="row">
                <div class="col-lg-6">
                  <div class="box">
                    <div class="box-header">
                    <h3 class="box-title">Status Selesai </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                      <table class="table table-condensed">
                        <tbody>
                          <tr>
                            <th style="width: 10px">No</th>
                            <th>Kategori</th>
                            <th style="width: 40px">Jumlah Mahasiswa</th>
                          </tr>
                          <tr>
                            <td>1</td>
                            <td>Pengajuan Judul</td>
                            <td><span class="badge bg-blue"><?php echo @$jmlh_pj->num_rows();?></span></td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>Proposal Tesis</td>
                            <td><span class="badge bg-green"><?php echo @$jmlh_pt->num_rows();?></span></td>
                          </tr>
                          <!-- <tr>
                            <td>3</td>
                            <td>Seminar Hasil Penelitian</td>
                            <td><span class="badge bg-yellow"><?php echo @$jmlh_shp->num_rows();?></span></td>
                          </tr> -->
                          <tr>
                            <td>4</td>
                            <td>Tesis</td>
                            <td><span class="badge bg-red"><?php echo @$jmlh_t->num_rows();?></span></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="box">
                    <div class="box-header">
                    <h3 class="box-title">Status Dalam Proses </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                      <table class="table table-condensed">
                        <tbody>
                          <tr>
                            <th style="width: 10px">No</th>
                            <th>Kategori</th>
                            <th style="width: 40px">Jumlah Mahasiswa</th>
                          </tr>
                          <tr>
                            <td>1</td>
                            <td>Pengajuan Judul</td>
                            <td><span class="badge bg-blue"><?php echo @$jmlh_p_pj->num_rows();?></span></td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>Proposal Tesis</td>
                            <td><span class="badge bg-green"><?php echo @$jmlh_p_pt->num_rows();?></span></td>
                          </tr>
                          <!-- <tr>
                            <td>3</td>
                            <td>Seminar Hasil Penelitian</td>
                            <td><span class="badge bg-yellow"><?php echo @$jmlh_p_shp->num_rows();?></span></td>
                          </tr> -->
                          <tr>
                            <td>4</td>
                            <td>Tesis</td>
                            <td><span class="badge bg-red"><?php echo @$jmlh_p_t->num_rows();?></span></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>




                <div class="col-lg-12">
                  <div class="box">
                    <div class="box-header">
                    <h3 class="box-title">Pengajuan Judul</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                    <?php echo $tabel_pj;?>
                    </div>
                  </div>
                </div>

                <div class="col-lg-12">
                  <div class="box">
                    <div class="box-header">
                    <h3 class="box-title">Proposal Tesis</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                    <?php echo $tabel_pt;?>
                    </div>
                  </div>
                </div>
                <!-- <div class="col-lg-12">
                  <div class="box">
                    <div class="box-header">
                    <h3 class="box-title">Seminar Hasil Penelitian</h3>
                    </div>
                    <div class="box-body no-padding">
                    <?php //echo $tabel_shp;?>
                    </div>
                  </div>
                </div> -->
                <div class="col-lg-12">
                  <div class="box">
                    <div class="box-header">
                    <h3 class="box-title">Tesis</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                    <?php echo $tabel_t;?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div><!-- ./col -->


          <div class="col-lg-3 col-xs-12" style="padding:0">
            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-orange">
                <div class="inner">
                  <h3>IDS</h3>
                  <p>Progres Mahasiswa</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="<?php echo site_url($this->dir.'/Ids_mahasiswa') ?>" class="small-box-footer" target="_blank">Tampilkan IDS <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->

            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>IDS</h3>
                  <p>Jadwal Ujian Tesis</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="<?php echo site_url($this->dir.'/Ids_jadwal') ?>" class="small-box-footer" target="_blank">Tampilkan IDS <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->

            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo @$jmlh_p_pj->num_rows();?></h3>
                  <p>Pengajuan Judul</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="<?php echo site_url($this->dir.'/Pengajuan_judul') ?>" class="small-box-footer">Tampilkan Data <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo @$jmlh_p_pt->num_rows();?></h3>
                  <p>Proposal Tesis</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="<?php echo site_url($this->dir.'/Proposal_tesis') ?>" class="small-box-footer">Tampilkan Data <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>


            <!-- <div class="col-lg-12 col-xs-12">
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php //echo @$jmlh_p_shp->num_rows();?></h3>
                  <p>Seminar Hasil Penelitian</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="<?php //echo site_url($this->dir.'/Seminar_hp') ?>" class="small-box-footer">Tampilkan Data <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div> -->


            <div class="col-lg-12 col-xs-12">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php echo @$jmlh_p_t->num_rows();?></h3>
                  <p>Tesis</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="<?php echo site_url($this->dir.'/Tesis') ?>" class="small-box-footer">Tampilkan Data <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>


            </div><!-- ./col -->
          </div>
