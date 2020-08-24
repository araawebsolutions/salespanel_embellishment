<div class="modal fade bs-example-modal-lg checklist-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"

     aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content blue-background">

            <div class="modal-header checklist-header" style="padding-bottom: 0rem !important;">

                <div class="col-md-12">

                    <h4 class="modal-title checklist-title" id="myLargeModalLabel">Design Team Checklist for Print Job

                        Number : PJ<?=$jobno?></h4>

                    <p class="timeline-detail text-center">Please answer the following questions within <span

                            class="highlight-red">2 hours</span> of order appearing on your screen.</p>

                    <h5 class="modal-title checklist-title" id="myLargeModalLabel" style="text-align: center !important;">

                    Submitted by: <?=$this->Artwork_model->get_operator($row['Operator']);?></h5>        

                </div>

            </div>

            <div class="modal-body p-t-0">

                <div class="panel-body">



                   <input type="hidden" name="jobno" value="<?=$jobno?>">

                    <table class="table table-bordered taable-bordered f-14">

                        <thead>

                        <tr>

                            <th class="text-center">Sr.</th>

                            <th>Questions</th>

                            <th colspan="2" class="text-center">Options</th>



                        </tr>

                        </thead>

                        <tbody>

                        <tr>

                            <td class="text-center">1</td>

                            <td>CO file colour ?</td>

                            <td colspan="2" style="text-align: center;"><?=($row['q1']==1)?"CMYK":"RGB"?></td>

                        </tr>

                        <tr>

                            <td class="text-center">2</td>

                            <td>CO file is editable ?</td>

                            <td colspan="2" style="text-align: center;"><?=($row['q2']==1)?"YES":"NO"?></td>

                        </tr>

                        <tr>

                            <td class="text-center">3</td>

                            <td>Artwork is compatible with lable size ?</td>

                            <td colspan="2" style="text-align: center;"><?=($row['q3']==1)?"YES":"NO"?></td>

                        </tr>

                        <tr>

                            <td class="text-center">4</td>

                            <td>Artwork resolution is fine ?</td>

                            <td colspan="2" style="text-align: center;"><?=($row['q4']==1)?"YES":"NO"?></td>

                        </tr>

                        <tr>

                            <td class="text-center">5</td>

                            <td>Any font issue ?</td>

                            <td colspan="2" style="text-align: center;"><?=($row['q5']==1)?"YES":"NO"?></td>

                        </tr>

                        <tr>

                            <td class="text-center">6</td>

                            <td>Artwork need to redo ?</td>

                            <td colspan="2" style="text-align: center;"><?=($row['q6']==1)?"YES":"NO"?></td>

                        </tr>

                        <tr>

                            <td class="text-center">7</td>

                            <td>Artwork is compatible for bleed ?</td>

                            <td colspan="2" style="text-align: center;"><?=($row['q7']==1)?"YES":"NO"?></td>

                        </tr>

                        <tr>

                            <td class="text-center">8</td>

                            <td>Images' link in file are missing ?</td>

                            <td colspan="2" style="text-align: center;"><?=($row['q8']==1)?"YES":"NO"?></td>

                        </tr>
                       
                        <tr>

                            <td class="text-center">9</td>

                            <td>Sequential / Variable Data Job ?</td>

                            <td colspan="2" style="text-align: center;"><?=($row['q9']==1)?"YES":"NO"?></td>

                        </tr>
                        

                        </tbody>

                    </table>

          



                    <p class="message-field-title">Feedback, requirement or any other issue:</p>

                      <div class="col-12 no-padding">

                        <textarea style="width: 100%;" class="form-control blue-text-field" rows="5" name="comment"readonly><?=$row['comment']?></textarea>

                      </div>

                   <span class="m-t-t-10 pull-right">

                    <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-outline-dark waves-light waves-effect btn-countinue m-r-10 ">Close</button></span>



                </div>

            </div>

        </div>

        <!-- /.modal-content -->

    </div>

    <!-- /.modal-dialog -->

</div>







 