<link href="<?= APPROOT ?>css/bootstrap-datetimepicker.min.css" rel="stylesheet">
 <script type="text/javascript" src="<?= APPROOT ?>js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
 
<script>
            jQuery(document).ready(function($) {
                
                    $('.form_date').datetimepicker({
                    language:  'en',
                    weekStart: 1,
                    todayBtn:  1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 2,
                    minView: 2,
                    endDate: new Date(),
                    forceParse: 0
                });
            });
    </script>

    
    	<div class="login-form" id="login-form" style="width:95%;left:2%;position:absolute;top:12%;">
    		<!-- Toggle for Primary Applicant starts -->
                    <div id="PrimaryApplicantToggle" class="PrimaryApplicantToggle"> 
                         <legend>Search your Listings</legend>
                         
                          
                            <div class="full">
                                <div class="col-sm-2">
                                    <span><label>Start Date Range (yyyy-mm-dd)</label></span>
                                        <span>
                                           
                                             <div class="controls input-append date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="Date1" data-link-format="yyyy-mm-dd">
                                                <input size="16" type="text" value="" readonly>
                                                <span class="add-on"><i class="icon-remove"></i></span>
                                                <span class="add-on"><i class="icon-th"></i></span>
                                            </div>
                                            <input type="hidden" name="Date1" id="Date1" value="" />
                                        </span>
                                </div>

                                <div class="col-sm-2">
                                    <span><label>End Date Range (dd/mm/yyyy)</label></span>
                                        <span>
                                           
                                             <div class="controls input-append date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="Date2" data-link-format="yyyy-mm-dd">
                                                <input size="16" type="text" value="" readonly>
                                                <span class="add-on"><i class="icon-remove"></i></span>
                                                <span class="add-on"><i class="icon-th"></i></span>
                                            </div>
                                            <input type="hidden" name="Date2" id="Date2" value="" />
                                        </span>
                                </div>

                                <div class="col-sm-2">
                                    <span><label>Start Credit Score</label></span>
                                    <span>
                                    	<input name="StartCreditScore" id="StartCreditScore" type="number" min="300" max="900" placeholder="Start Credit Score" class="textbox" >
                                    </span>
                                </div>

                                <div class="col-sm-2">
                                    <span><label>End Credit Score</label></span>
                                    <span><input name="EndCreditScore" id="EndCreditScore" type="number" min="300" max="900" placeholder="End Credit Score" class="textbox" ></span>
                                </div>

                                <div class="col-sm-2">
                                     <span><label>Start Income</label></span>
                                    <span><input name="StartIncome" id="StartIncome" type="text" placeholder="Starting Income" min="0" max="999999999" class="textbox" ></span>
                                </div>

                                <div class="col-sm-2">
                                     <span><label>End Income</label></span>
                                    <span><input name="EndIncome" id="EndIncome" type="text" placeholder="Ending Income" min="0" max="999999999" class="textbox" ></span>
                                </div>


                                <div class="clearfix"></div>

                                <div class="col-sm-2">
                                        <span><label>First and Last Name</label></span>
                                        <span><input name="FullName" type="text" placeholder="Enter First Name and Last Name" class="textbox" value=""></span>
                                </div>

                                <div class="col-sm-2">
                                     <span><label>City</label></span>
                                    <span><input name="City" id="City" type="text" placeholder="Search by City" class="textbox" ></span>
                                </div>

                                <div class="col-sm-2">
                                     <span><label>Province</label></span>
                                    <span><input name="Province" id="Province" type="text" placeholder="Search by Province" class="textbox" ></span>
                                </div>
                                
                                <div class="col-sm-2">
                                     <span><label>Phone Number</label></span>
                                    <span><input name="Phone" id="Phone" type="text" placeholder="Search by Phone Number" class="textbox" ></span>
                                </div>

                                


                                
                                <div class="col-sm-2">
                                        <span><label>Length of employment?</label></span>
                                        <span><select id="EmpLength" name="EmpLength" >
                                            <option value=""></option>
                                            <option value="Less than 30"> < 1 month</option>
                                            <option value="Less than 90"> < 3 months</option>
                                            <option value="Less than 1"> < 1 year</option>
                                            <option value="One to Two">1 - 2 Years</option>
                                            <option value="More than 2">> 2 Years</option>
                                            
                                        </select></span>
                                </div>
                                
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

