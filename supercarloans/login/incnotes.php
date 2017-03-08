<?php

	require_once("../include/files.php");
		

$ContactInfoId = $_REQUEST['ContactInfoId'];
$ContactInfo = new ContactInfo();
$ContactInfo->loadContactInfo($ContactInfoId);

?>

					<p>&nbsp;</p>
	                <form method="post" action="#">
	                <input type="hidden" name="ContactInfoId" value="<?= $Encrypt->encrypt($ContactInfoId) ?>">
                    	<h3>Notes: <?= ContactInfo::GetFullName($ContactInfo->Id); ?></h3>

                    	<div class="col-sm-8">
                            <span>
                            	<input type="text" name="Notes" id="messageNotes" placeholder="Please type your notes" required="required"  />
                            </span>
                        </div>
                        <div class="col-sm-4">
                            <span>
                            	<input type="submit" class="btn btn-primary " id="SubmitIncSearch" name="SubmitIncSearch" value="Post Notes" style="width:50%;"/>
                            </span>
                        </div>
                    </form>
                    <div class="clearfix"></div>

    <?php

		$count = 1;
		$NotesResultset = Notes::LoadNotesInfo('ContactInfoId',$ContactInfoId);
		if($NotesResultset->TotalResults>0)
		{
	?>
			<div class="table-responsive">
			    <table class="table">
			        <thead>
			            <tr>
			                <th>#</th>
			                <th>Notes</th>
			                <th>Date&nbsp;Posted</th>
			                <th>&nbsp;</th>
			            </tr>
			        </thead>
			    <tbody>
	<?php

			for($x = 0; $x < $NotesResultset->TotalResults ; $x++)
			{
	?>
        	<tr>
                <td><?php echo $count; ?></td>
            
                <td><?php echo $NotesResultset->Result[$x]['Notes']; ?></td>
                <td><?php echo $NotesResultset->Result[$x]['DatePosted']; ?></td>
           
            </tr>
            
      <?php
    			$count++;
			}
		?>
				 </tbody>
			</table>
		</div>
        <div class="clearfix"></div>
		<?php

		}

		?>
		<?= ($ContactInfo->Notes) ? $ContactInfo->Notes : '' ?>