<div class="">
    <div class="dataTables_wrapper">
        <div class="header">
            <h3>Euro Standard Logs</h3>
        </div>
        <div class="top">
            <div id="table-example_length">
                <div id="my_table_wrapper" class="dataTables_wrapper" role="grid">
                    <table id="my_table" class="table dataTable" aria-describedby="my_table_info">
                        <thead>
                            <tr role="row">
                                <th width="50px;">Code</th>
                                <th width="150px">Changed to</th>
                                <th width="150px">Operator</th>
                                <th width="150px">Date</th>
                            </tr>
                        </thead>
					
                        <tbody role="alert" aria-live="polite" aria-relevant="all" style="max-height:100px;overflow:scroll;">
                            <? 
                            foreach($data as $row){
                                $operator = $this->artworkModel->get_operator($row->user_id);
                            ?>
                            <tr class="">
                                <td class=""><b><?=$row->code?></b></td>
                                <td class=""><b><?=$row->converted?> Die</b></td>
                                <td class=""><b><?=$operator?></b></td>
                                <td class=""><?php echo ($row->created_at); ?></td>
                            </tr>
                            <? } ?>  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>