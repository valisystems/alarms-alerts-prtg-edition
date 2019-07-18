<?php include_once APP_PATH.'admin/template/header.php';?>


<?php
    if (JAK_ASACCESS) $apedit = BASE_URL.'admin/index.php?p=device&amp;sp=cfiles';
?>
<script type="text/javascript" src="../../plugins/device/js/urls.js"></script>

<div class="row">
    <div class="col-md-7">
        <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Device Plugin Useful URL</h3>
              </div><!-- /.box-header -->
              <div class="box-body">
                    <table class="table table-striped">
                        <tr>
                            <td>Device json url</td>
                            <td>
                                <span id="json_url">http://<?= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT']?>/index.php?p=device&sp=ajax&ssp=signalupdate&auth=<?=$jkv["deviceauthkey"]?></span>
                                <button onclick="copyToClipboard('#json_url')" type="button" class="btn btn-default btn-sm">Copy</button>
                            </td>
                        </tr>
                        <tr>
                            <td>MI position</td>
                            <td>
                                <span id="mi_position">http://<?= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT']?>/miposition.php?auth=<?=$jkv["deviceauthkey"]?></span>
                                <button onclick="copyToClipboard('#mi_position')" type="button" class="btn btn-default btn-sm">Copy</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Maxi Box to EMS lite</td>
                            <td>
                                <span id="maxi_vox">http://<?= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT']?>/maxi_to_litecms.php</span>
                                <button onclick="copyToClipboard('#maxi_vox')" type="button" class="btn btn-default btn-sm">Copy</button>
                            </td>
                        </tr>
                        <tr>
							
                            <td>Cancel Alarm for all devices</td>
                            <td>
								<span id="cancel_all_alarms_url">http://<?= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT']?>/index.php?p=device&amp;sp=upd_event&amp;action=cancel_all</span>
                                <button onclick="copyToClipboard('#cancel_all_alarms_url')" type="button" class="btn btn-default btn-sm">Copy</button>
							</td>
                        </tr>
						<tr>
                            <td>PRTG Status link for all device</td>
                            <td>
								<span id="prtg_status_link_url">http://<?= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT']?>/index.php?p=device&sp=prtg&action=all</span>
                                <button onclick="copyToClipboard('#prtg_status_link_url')" type="button" class="btn btn-default btn-sm">Copy</button>
							</td>
                        </tr>
                        <tr>
                            <td>Cancel Alarm for one device</td>
                            <td>
                                <input type="text" name="basename" placeholder="e.g miPos_630114"  />
                                <input type="text" name="device" placeholder="e.g AB00180"  />
                                <button data-type="single_alarm" class="btn btn-default btn-sm generateUrl">Generate URL</button>
                        </tr>
                        <tr>
                            <td>Alert URL</td>
                            <td>
                                <input type="text" name="acc" placeholder="Hunt group e.g 1500@localhost"  />
                                <input type="text" name="dest" placeholder="Call from e.g 100"  />
                                <button data-type="alert" class="btn btn-default btn-sm generateUrl">Generate URL</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Call URL</td>
                            <td>
                                <input type="text" name="src" placeholder="From e.g 101" />
                                <input type="text" name="dest" placeholder="100" />
                                <button data-type="call" type="button" class="btn btn-default btn-sm generateUrl">Generate URL</button>
                            </td>
                        </tr>

                        <tr>
                            <td>PBX Call URL</td>
                            <td>
                                <input type="hidden" name="pbx_url" value="http://<?= $jkv["devicepbxhost"] . "/remote_call.htm?" ?>" />
                                <input type="hidden" name="pbx_uri" value="<?= "user=" . $jkv["devicepbx_default_ext"] ."&auth=" . $jkv["devicepbx_default_ext"] . ":" . $jkv["devicepbx_ext_pass"] . "&connect=true&dest=" ?>" />
                                <input type="text" name="src" placeholder="From e.g 101" />
                                <input type="text" name="dest" placeholder="Destination e.g 101" />
                                <button data-type="pbxcall" type="button" class="btn btn-default btn-sm generateUrl">Generate URL</button>
                            </td>
                        </tr>

                        <tr>
                            <td>Detailed Call URL</td>
                            <td>
                                <?php $url = $jkv["devicepbxhost"] . "/remote_call.htm?"; ?>
                                <input type="hidden" name="pbx_url" value="http://<?= $url ?>" />
                                <input type="text" name="ext" placeholder="Extension e.g 100@localhost" />
                                <input type="text" name="ext_pass" placeholder="Password e.g 123456789" />
                                <input type="text" name="dest" placeholder="Destination e.g 101" />
                                <input type="text" name="src" placeholder="From e.g 101" />
                                <button data-type="detailedCallUrl" type="button" class="btn btn-default btn-sm generateUrl">Generate URL</button>
                            </td>
                        </tr>

                        <tr>
                            <td>CAM URL</td>
                            <td>
                                <input type="text" name="cam_number" placeholder="1" />
                                <button data-type="camurl" type="button" class="btn btn-default btn-sm generateUrl">Generate URL</button>
                            </td>

                        </tr>

                        <tr>
                            <td>Catch URL</td>
                            <td>
                                <span id="catch_url">http://<?= $_SERVER['SERVER_NAME'] . ':' .$_SERVER['SERVER_PORT']?>/index.php?p=device&sp=catch</span>
                                <button onclick="copyToClipboard('#catch_url')" type="button" class="btn btn-default btn-sm">Copy</button>
                            </td>
                        </tr>
                    </table>
              </div>
         </div>
     </div>
</div>



<?php include_once APP_PATH.'admin/template/footer.php';?>
