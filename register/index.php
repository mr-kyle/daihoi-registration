<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_cApp.php' ?>
<!DOCTYPE html>
<html lang="en">
<head> 

    <?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/_meta.php'); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/_scripts.php'); ?>
    
    <script type="text/javascript" src="/js/charlimit.js"></script>
    <script type="text/javascript">
        $(function () {
            $('#tNotes').charlimit({ 'limit':500, 'color':1});
        });
    </script>

    <style type="text/css">
        @media (min-width: 768px) {
            .custom .age { max-width: 80px; }
            .custom select { font-size: 85%; padding: 4px; }
        }

        select.validate-error {
            background-color: #FBDDE2 !important;
        }

    </style>

</head>
<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/_menu.php');?>

    <div class="container body-content" id="body-wrapper">

        <div>

            <h1>Registration</h1>


            <div>&nbsp;</div>

            <div class="panel panel-info border-none">
                <div class="panel-heading">Important Information</div>

                <div class="panel-body">

                    <div class="col-lg-10 col-lg-offset-1 ">

                        <div class="row">

                            <div class="col-md-6 ">

                                <h4><i class="fa fa-plane text-info"> </i> Airport transfers </h4>
                                <p>Bus transfer from and to airport on the 27th and the 31st will be provided. $25 separate fee applies per person (both ways). Please select <b>Airport Transfer</b> when you register.</p>
                                <div>&nbsp;</div>

                            </div>

                            <div class="col-md-6">
                                <h4><i class="fa fa-wheelchair text-info"> </i> Disabilities </h4>
                                <p>
                                    People with special needs will need to ensure that your requirements are known at the time of registration.
                                </p>
                                <div>&nbsp;</div>
                            </div>
                        </div>



                        <div class="clearfix">&nbsp;</div>
                        <div class="row">
                            <div class="col-md-6">
                                <h4><i class="fa fa-cutlery text-info"> </i> Food </h4>
                                <p>
                                    Vietnamese cuisine will be the main dishes provided at the Melbourne 2018 conference.
                                    Special dietary requirements must be made known at the time of registration – we cannot guarantee all different dietary needs can be met.
                                </p>
                                <div>&nbsp;</div>

                            </div>


                            <div class="col-md-6">
                                <h4><i class="fa fa-bank  text-info"> </i> Payment </h4>
                                <p>
                                    Payment is to be made to the below account.
                                    <?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/_bankdetails.php');?>
                                </p>
                                <div>&nbsp;</div>
                            </div>

                            <div class="col-sm-6">
                                <h4><i class="fa fa-envelope text-info"> </i> Correspondence address</h4>
                                <p>
                                    PO Box 2114, Footscray VIC 3011, Australia.<br>
                                    <b>website:</b> christianconference.org.au<br>
                                    <b>email:</b> info@christianconference.org.au
                                    
                                </p>
                                <div>&nbsp;</div>
                            </div>                            


                        </div>

                        <div class="clearfix">&nbsp;</div>

                    </div>
                    <div class="col-lg-1"></div>

                </div>



            </div>


            <div>&nbsp;</div>
            <div>&nbsp;</div>


            <div class="panel panel-info border-none">

                <div class="panel-heading">Fee Structure</div>

                <div class="panel-body">

                    <p>All prices are in AUD unless otherwise specified.</p>


                    <div class="row">

                        <div class="col-md-4 col-lg-4">

                            <div class="well well-offset-color white-bg">
                                <table class="table">
                                    <caption>Standard Fee</caption>
                                    <thead>
                                        <tr>
                                            <th>Age</th>
                                            <th class="standard-price">Price</th>
                                            <th class="text-right early-bird">Early Bird<br><span style="font-size:1rem">payment made before 15/09/2018</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>5 and under (shared bed with parents)</td>
                                            <td class="standard-price">$50</td>
                                            <td class="text-right early-bird">$30</td>
                                        </tr>
                                        <tr>
                                            <td>6 - 12</td>
                                            <td class="standard-price">$350</td>
                                            <td class="text-right early-bird">$330</td>
                                        </tr>
                                        <tr>
                                            <td>13 - 64</td>
                                            <td class="standard-price">$450</td>
                                            <td class="text-right early-bird">$430</td>
                                        </tr>
                                        <tr>
                                            <td>65 and above or Pensioner</td>
                                            <td class="standard-price">$400</td>
                                            <td class="text-right early-bird">$380</td>
                                        </tr>
                                    </tbody>

                                </table>

                            </div>

                        </div>


                        <div class="col-md-4 col-lg-4">

                            <div class="well well-offset-color white-bg">

                                <table class="table  ">

                                    <caption>Family Discount</caption>
                                    <tbody>

                                        <tr>
                                            <td colspan="2">
                                                Family with 2 parents & 2 or more children gets family discount.
                                                First oldest child full fee according to standard fee
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold text-right">Eligibility</td>
                                            <td class="standard-price text-bold text-right">Discount</td>
                                        </tr>                                        
                                        <tr>
                                            <td>2nd child thereafter 5 y.o or under</td>
                                            <td class="standard-price text-right">Free</td>
                                        </tr>
                                        <tr>

                                            <td>2nd child thereafter 6 y.o and above</td>
                                            <td class="standard-price text-right">$100</td>
                                        </tr>

                                    </tbody>

                                </table>

                            </div>


                        </div>



                        <div class="col-md-4 col-lg-4">

                            <div class="well well-offset-color white-bg">

                                <table class="table">
                                    <caption>Transport</caption>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <p>On Thursday, 27 December, there will be scheduled buses to pick you up from Tullamarine Airport to Đại Hội campus. Buses departure 10:00AM and 3:00PM from Tullamarine Airport.</p>
                                                <p>On Monday, 31 December, there will be buses to take you from campus back to Tullamarine Airport.</p>
                                                <p>Buses departure 11:00 AM (arriving Tullamarine Airport 1:30PM), and 5:00PM (arriving Tullamarine Airport 7:30pm)</p>
                                                <p>The cost is AUD 25 per person per round trip. Please select <b>Airport Transfer</b> when you register.</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                        </div>


                    </div>


                </div>

                <div id="fee-structure-end"></div>
            </div>


            <div class="row" id="rego-summary">
                <div class="well">
                    <h2 class="text-center">Summary</h2>
                    <div id="summary-content">
                    </div>
                    <div class="clearfix">&nbsp;</div>
                </div>
            </div>


                <div>&nbsp;</div>
                <div>&nbsp;</div>

    
            <form id="rego-form" onsubmit="return false;">

                <div class="panel panel-info  border-none">

                    <div class="panel-heading">Registration Form</div>
                    <div class="panel-body" style="padding:24px">

                            <div class="row">
                                <div class="col-lg-12">
                                    <h3 style="float: left;">Main Contact</h3>
                                    <!-- <button onclick="javascript:tour.start();" class="btn btn-info" style="border-radius: 10px; border-color:transparent;  background-color: steelblue;    color: white; float: right; margin-top: 15px; padding-right: 10px; padding-left: 10px;"> <i class="fa fa-question-circle" aria-hidden="true"></i> Help</button> -->
                                </div>
                                <div class="clearfix"></div>
                            </div>


                            <div class="form-horizontal form-bg bordered padding"  >

                                <div class="bs-callout bs-callout-info col-lg-11 col-lg-push-1">

                                    <h4 onclick="SUBMISSION.fillRandomInfo()"><i class="fa fa-user text-info"> </i> Main Contact </h4>

                                    The nominated person will receive all the communication via email and or contact number. Please supply valid update to date details.

                                    <div>&nbsp;</div>

                                    <div class="text-warning"><span class="label label-warning">IMPORTANT</span> It is important the Name is entered correctly (especially Vietnamese punctuations and accents) as this field will be used for your name tag.</div>


                                </div>

                                <div class="clearfix">&nbsp;</div>
                                <div class="clearfix">&nbsp;</div>

                                <div class="form-group">

                                    <label class="col-md-2 control-label">Full Name</label>

                                    <div class="col-md-7">

                                        <div class="row">
                                            <div class="col-md-6">
                                            <input type="text" name="FullName" class="form-control" id="tFullName"
                                                   maxlength="50" placeholder="Firstname"
                                                   data-rule-required="true" />                                        
                                            </div>
                                            <div class="col-md-6">
                                            <input type="text" name="Surname" class="form-control" id="tSurname"
                                                   maxlength="50" placeholder="Surname"
                                                   data-rule-required="true" />                    
                                            </div>                                        
                                        </div>

                                    </div>



                                    <label class="col-md-1 control-label">Age</label>
                                    <div class="col-md-2">

                                         <select name="tAge" id="tAge" class="form-control">
                                             <option>16</option>
                                             <option>17</option>
                                             <option>18</option>
                                             <option>19</option>
                                             <option>20</option>
                                             <option>21</option>
                                             <option>22</option>
                                             <option>23</option>
                                             <option>24</option>
                                             <option>25</option>
                                             <option>26</option>
                                             <option>27</option>
                                             <option>28</option>
                                             <option>29</option>
                                             <option>30</option>
                                             <option>31</option>
                                             <option>32</option>
                                             <option>33</option>
                                             <option>34</option>
                                             <option>35</option>
                                             <option>36</option>
                                             <option>37</option>
                                             <option>38</option>
                                             <option>39</option>
                                             <option>40</option>
                                             <option>41</option>
                                             <option>42</option>
                                             <option>43</option>
                                             <option>44</option>
                                             <option>45</option>
                                             <option>46</option>
                                             <option>47</option>
                                             <option>48</option>
                                             <option>49</option>
                                             <option>50</option>
                                             <option>51</option>
                                             <option>52</option>
                                             <option>53</option>
                                             <option>54</option>
                                             <option>55</option>
                                             <option>56</option>
                                             <option>57</option>
                                             <option>58</option>
                                             <option>59</option>
                                             <option>60</option>
                                             <option>61</option>
                                             <option>62</option>
                                             <option>63</option>
                                             <option>64</option>
                                             <option>65</option>
                                             <option>66</option>
                                             <option>67</option>
                                             <option>68</option>
                                             <option>69</option>
                                             <option>70</option>
                                             <option>71</option>
                                             <option>72</option>
                                             <option>73</option>
                                             <option>74</option>
                                             <option>75</option>
                                             <option>76</option>
                                             <option>77</option>
                                             <option>78</option>
                                             <option>79</option>
                                             <option>80</option>
                                             <option>81</option>
                                             <option>82</option>
                                             <option>83</option>
                                             <option>84</option>
                                             <option>85</option>
                                             <option>86</option>
                                             <option>87</option>
                                             <option>88</option>
                                             <option>89</option>
                                             <option>90</option>
                                         </select>


                                    </div>



                                </div>







                                <div class="form-group">
                                    <label class="col-md-2 control-label">Role</label>                  
                                    <div class="col-md-7">
                                            <select name="tRole" id="tRole" class="form-control role" data-rule-required="true">
                                                <?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/_roles.php');?>
                                            </select>     

                                    </div>

                                    <label class="col-md-1 control-label">Gender</label>
                                    <div class="col-md-2">
                                            <select name="tGender" id="tGender" class="form-control gender" data-rule-required="true">
                                                <option value="">- M/F -</option>
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                            </select>      
                                    </div>
          

                                </div>




                                <div class="form-group">
                                    <label class="col-md-2 control-label">State</label>
                                    <div class="col-md-3">
                                            <select name="tState" id="tState" class="form-control state" data-rule-required="true">
                                                <option value="">-- YOUR STATE --</option>
                                                <option value="VIC">VIC</option>
                                                <option value="NSW">NSW</option>
                                                <option value="QLD">QLD</option>
                                                <option value="SA">SA</option>
                                                <option value="WA">WA</option>
                                                <option value="TAS">TAS</option>
                                                <option value="ACT">ACT</option>
                                                <option value="NT">NT</option>
                                            </select> 
                                    </div>


                                    <label class="col-md-1 control-label">Church</label>
                                    <div class="col-md-6">
                                        <select name="tChurch" id="tChurch" class="form-control" data-rule-required="true">
                                            <?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/_churches.php');?>
                                        </select>
                                    </div>



                                </div>



                                <div class="form-group">

                                    <label class="col-md-2 control-label">Email</label>

                                    <div class="col-md-10">

                                        <input type="email" name="tEmail" id="tEmail" class="form-control" maxlength="200" placeholder="Email Address"
                                               data-rule-email="true"
                                               data-msg-email="Please enter a valid email address"
                                               data-rule-required="true" />


                                    </div>


                                </div>




                                <div class="form-group">

                                    <label class="col-md-2 control-label">Phone</label>

                                    <div class="col-md-10">

                                        <input type="text" id="tPhone" name="tPhone" class="form-control" maxlength="12" 
                                        data-rule-required="true" 
                                        data-msg-required="Contact number required" />
                                        <span id="phone-valid-msg" class="hidden label label-success">✓ Valid</span>
                                        <span id="phone-error-msg" class="hidden label label-danger">Invalid number</span>

                                    </div>

                                </div>






                                <div class="form-group">

                                    <label class="col-md-2 control-label"> </label>

                                    <div class="col-md-3">
                                        <div class="checkbox checkbox-info form-control1">
                                            <input type="checkbox" class="airport-transfer styled" value="1" id="airport00" name="airport00">
                                            <label for="airport00">Airport Transfer</label>
                                        </div>

                                    </div>



                                    <div class="col-md-7">

                                        <div class="checkbox checkbox-info form-control1 hidden">
                                            <input type="checkbox" class="discount-airbed styled" value="1" id="airbed00" name="airbed00">
                                            <label for="airbed00">Airbed Discount</label>
                                        </div>                          
                                        <div class="checkbox checkbox-info form-control1">
                                            <input type="checkbox" class="pensioner styled" value="1" id="pensioner00" name="pensioner00" onchange="alertPensioner(this,'main');">
                                            <label for="pensioner00">Pensioner</label>
                                        </div> 
                                    </div>

                                </div>



                                <div class="form-group">
                                    <label class="col-md-2 control-label"> </label>
                                    <div class="col-md-offset-8 col-md-2 ">
                                        <div class="input-group">
                                            <div class="input-group-addon line-total">$ 0.00</div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!--END MAIN CONTACT -->
                            


                            <div class="clearfix">&nbsp;</div>


                            <h3>Other Registrants</h3>

                        <div class="bordered padding">
                            <div class="bs-callout bs-callout-info col-lg-12">

                                <h4><i class="fa fa-users text-info"> </i> Members </h4>
                                <p>Please supply the correct details of all other persons you would like to register under this registration.</p>
                                    <div>&nbsp;</div>
                                    <div class="text-warning"><span class="label label-warning">IMPORTANT</span> It is important the Name is entered correctly (especially Vietnamese punctuations and accents) as this field will be used for your name tag.</div>

                            </div>



                            <div class="clearfix">&nbsp;</div>
                            <div class="clearfix">&nbsp;</div>

                            <div class="col-md-12">
                                <div class="form-inline custom">

                                    <div class="row other-registrants">
                                        <div class="form-group">
                                            <label class="sr-only">Name:</label>
                                            <input type="text" class="form-control name" name="name-{0}" placeholder="Firstname" />
                                        </div>

                                        <div class="form-group">
                                            <label class="sr-only">Surname:</label>
                                            <input type="text" class="form-control surname" name="surname-{0}" placeholder="Surname" />
                                        </div>

                                        <div class="form-group">
                                            <label class="sr-only">Age:</label>
                                            <input type="number" class="form-control age" name="age-{0}" placeholder="Age" maxlength="3" min="0" max="100" step="1" />

                                        </div>


                                        <div class="form-group">

                                            <label class="sr-only">Gender:</label>
                                            <select class="form-control gender" name="gender-{0}">
                                                <option value="">M/F</option>
                                                <option value="M">M</option>
                                                <option value="F">F</option>

                                            </select> 


                                        </div>


                                        <div class="form-group">
                                            <label class="sr-only">Relation:</label>
                                            <select name="relation-{0}" class="form-control relation">
                                                <?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/_relationships.php');?>
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <div class="checkbox checkbox-info form-control">
                                                <input type="checkbox" class="pensioner styled" value="1" id="pensioner-{0}" name="pensioner-{0}" onchange="alertPensioner(this,'other');">
                                                <label for="pensioner-{0}">Pensioner</label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="sr-only">Discount:</label>
                                            <select name="family-{0}" class="form-control family-discount">
                                                <?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/_familydiscounts.php');?>
                                            </select>
                                        </div>



                                        <div class="form-group hidden">
                                           <div class="checkbox checkbox-info form-control hidden">
                                                <input type="checkbox" class="discount-airbed styled" value="1" id="airbed-{0}" name="airbed-{0}">
                                                <label for="airbed-{0}">Airbed Discount</label>
                                            </div>

                                        </div>



                                        <div class="form-group">
                                            <div class="checkbox checkbox-info form-control">
                                                <input type="checkbox" class="airport-transfer styled" value="1" id="airport-{0}" name="airport-{0}">
                                                <label for="airport-{0}">Airport Transfer</label>
                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <select class="form-control role" name="role-{0}">
                                                <?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/_roles.php');?>
                                            </select>

                                        </div>



                                        <div class="form-group">
                                            <label class="sr-only">Fee:</label>
                                            <div class="input-group">
                                                <div class="input-group-addon line-total">$ 0.00</div>
                                            </div>

                                        </div>



                                        <div class="form-group btn-remove-row {1}" style="display:none;">
                                            <label class="sr-only">Action:</label>
                                            <div class="input-group btn-remove-row">
                                                <button class="btn btn-warning btn-sm pull-right" onclick="removeRow(this); return false;"> <span>x</span> </button>
                                            </div>
                                        </div>


                                    </div>


                                    <div class="row" id="add-more-button-row">
                                        <div class="col-md-12">
                                            <div>&nbsp;</div>
                                            <button class="btn btn-info btn-sm pull-right" onclick="addMoreRegistrants(); return false;"> <i class="fa fa-plus" aria-hidden="true"></i> MORE ROWS</button>
                                        </div>
                                    </div>

                                    <div>&nbsp;</div>


                                    <div class="row">
                                        <div class="form-group">
                                            <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                                            <div class="input-group pull-right">
                                                <div class="input-group-addon">$</div>
                                                <input type="number" class="form-control disabled text-right" disabled placeholder="Total Amount" id="TotalAmount" style="border-top:1px solid #eaeaea !important">
                                                <div class="input-group-addon">.00</div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                            </div>

                            <div class="clearfix">&nbsp;</div>
                        </div>

                        <!--END REGISTRANTS -->


                        <div>&nbsp;</div>
                        <div>&nbsp;</div>

                        <div class="row">
                            <div class="col-md-4">

                                <div class="panel panel-info  border-none">
                                    <div class="panel-heading">
                                        Additional Information
                                    </div>
                                    <div class="panel-body">
                                        <p>Please enter:</p>
                                        <ul>

                                            <li>dietary requests,</li>
                                            <li>airport information for transfer </li>
                                            <li>flight number, times, etc</li>
                                            <li>special needs</li>
                                            <li>disability requirements</li>

                                        </ul>                                        
                                    </div>

                                </div>

                         

                            </div>
                            <div class="col-md-8">
                                    <!-- <span class="help-block"></span> -->
                                    <textarea class="form-control" rows="8" id="tNotes" name="tNotes"></textarea>

                            </div>


                        </div>

                        <!--END ADDITIONAL -->

                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <div class="clearfix">&nbsp;</div>
                                <div class="clearfix">&nbsp;</div>
                                <hr>
                                <input accesskey="n" type="submit" class="btn btn-primary" style="max-width:450px; width:100%" value=" NEXT >> " />
                            </div>
                        </div>  

                        

                        </div>

                    </div>

               </div>
                <!-- // end rego form -->
            </form>

        </div>

    </div>

<div class="row fixed-top">

    <div class="col-md-12">

        <div class="panel clearfix no-radius transparent">

          <div id="callout" class="alert alert-warning no-radius">
            <a href="javascript:void(0); $('#callout').hide();" class="close">&times;</a>
            <div>
                <div style="float: left; display: block;    padding-right: 10px;">
                    <i class="fa fa-address-card fa-4x" aria-hidden="true"></i>
                </div>
                <div style="    display: block;    position: relative;">
                    <h3>Attention</h3>
                    <p>This alert box could indicate a warning that might need attention.</p>
                    <p class="text-right"><input type="button" class="btn btn-primary btn-sm" onclick="javascript:void(0); $('#callout').hide();" value="OK, I Understand" /></p>
                </div>
                <div class="clearfix"></div>
            </div>
           
          </div>

        </div>  

    </div>

</div>    
  



        <!-- footer -->
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/_footer.php');?> 

    <div id="json" style="display: none !important;"></div>    


    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title text-danger"> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Oh no...</h4>
          </div>
          <div class="modal-body text-center" style="padding-bottom: 35px; padding-top: 35px;">
            <p>
                
            </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>    


    <script src="/js/register_objects.js?v=13.<?php echo rand() ?>"></script>
    <script src="/js/register.js?v=13.<?php echo rand() ?>"></script>
    <script src="/register/submission.js?v=5.<?php echo rand() ?>"></script>

    <!-- shepherd -->
    <link href="shepherd-theme-arrows.css"  rel="stylesheet" type="text/css" />
    <link href="shepherd-helper.css"        rel="stylesheet" type="text/css" />
    <script src="tether.min.js"></script>
    <script src="shepherd.min.js"></script>

</body>


</html>







