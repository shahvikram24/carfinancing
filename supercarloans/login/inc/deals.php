<?php
$Package = new Package();
$PackageResultSet = $Package->GetPackages(false,false,' P. Status=1 ');
?>

    	<div class="contact-form" id="contact-form" style="width:95%;left:2%;">
    		<!-- Toggle for Primary Applicant starts -->
                    <div id="PrimaryApplicantToggle" class="PrimaryApplicantToggle"> 
                         <legend>Search your Listings</legend>
                         
                          
                            <div class="full">
                                

                                <div class="col-sm-3">
                                    <span><label>Dealership&nbsp;Name</label></span>
                                    <span>
                                    	<input name="DealershipName" id="DealershipName" type="text" placeholder="Dealership Name" class="textbox" >
                                    </span>
                                </div>

                                <div class="col-sm-3">
                                     <span><label>Dealership Plan</label></span>
                                    <span><select id="DealershipPlan" name="DealershipPlan" >
                                            <option value=""></option>
                                    <?php 
                                        for($x = 0; $x < $PackageResultSet->TotalResults ; $x++)
                                        {
                                                echo "<option value='". $Encrypt->encrypt($PackageResultSet->Result[$x]['Id']) ."'>".
                                                        $PackageResultSet->Result[$x]['Name']
                                                  . "</option>";
                                        }
                                    ?>                                        
                                </select></span>
                                </div>
                                <!-- <div class="col-sm-2">
                                    <span><label>City</label></span>
                                    <span><input name="City" id="City" type="text" placeholder="Search by City" class="textbox" ></span>
                                </div>
                                <div class="col-sm-2">
                                    <span><label>Province</label></span>
                                    <span><input name="Province" id="Province" type="text" placeholder="Search by Province" class="textbox" ></span>
                                </div>

                                -->
                                <div class="col-sm-2">
		                            <span><label>&nbsp;</label></span>
		                            <span>
		                            	<input type="submit" class="btn" id="SubmitSearch" name="SubmitSearch" value="Search" />
		                            </span>
		                        </div> 
                                <div class="clearfix"></div>
                                

                                <hr/>
                            </div> <!-- end of toggle div -->                          
                            
                    </div> <!-- Toggle for Primary Applicant ends -->
    	