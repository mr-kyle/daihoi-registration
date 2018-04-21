<div>
    <div class="print-only hidden col-lg-12">

        <!-- <h4 style="color: #CAAB71;     border-bottom: 1px solid #DF691A ;     padding-bottom: 10px;     margin-bottom: 25px;">Viewing Your Registraion</h4> -->

                   <table class="table table-responsive table-bordered table-striped" style="margin-bottom:10px">
                        <caption>Viewing Your Registraion</caption>
                    </table>        
            <div>
             

                <img style="float: left; margin: 0 10px 10px 10px;" src="https://chart.googleapis.com/chart?chs=120x120&cht=qr&chl={SHORT-URL}/register/view?ref={REFERENCE}&choe=UTF-8&chld=Q|0" align="left" />

                <p>
                    To view your registration at: <a href="{URL}/register/view/?ref={REFERENCE}">{URL}</a>
                    <br/>
                    Please use your reference: <b>{REFERENCE}</b>
                    
                </p>

                <div class="clearfix">&nbsp;</div>            

        </div>

        <div>&nbsp;</div>    

    </div>


    <div>&nbsp;</div>

    <!--PAYMENT-PROGRESS-->

    <div class="col-lg-6">

        <table class="table table-responsive table-bordered">
            <caption>Main Contact</caption>
            <thead>
                <tr>
                    <th colspan="2">{0}</th>
                </tr>

            </thead>

            <tbody>
                <tr>
                    <td>{1}</td>
                    <td>{2}yo</td>

                </tr>
                <tr>
                    <td>{3}</td>
                    <td>{4}</td>
                </tr>

                <tr>
                    <td>{5}</td>
                    <td>Gender: {6}</td>
                </tr>

                <tr>
                    <td>
                        Airport Transfer: {7}
                    </td>
                    <td>Pensioner: {8}</td>
                </tr>

                <tr>
                    <td colspan="2">({17}): {9}</td>
                </tr>

                <tr>
                    <td>Fee</td>
                    <td>${10}</td>
                </tr>

            </tbody>



        </table>

    </div>







    <div class="col-lg-6">

        <table class="table table-responsive table-bordered ">
            <caption>Additional Notes</caption>

            <thead>
                <tr>

                    <th>&nbsp; </th>
                </tr>

            </thead>
            <tbody>
                <tr>

                    <td>{11}</td>

                </tr>
            </tbody>
        </table>

    </div>

    <div class="col-lg-12 {12}">
        <div class="table-responsive">
            <table class="table table-responsive table-bordered table-striped table-last-col-right">
                <caption>Additional Registrants</caption>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Relation</th>
                        <th>Pensioner</th>
                        <th>Family<br>Discount</th>
                        <th>Airport<br>Transfer</th>
                        <th>Role</th>
                        <th>Fee</th>
                    </tr>
                </thead>

                <tbody>

                    {13} 

                </tbody>

                <tfoot>

                    <tr>

                        <td colspan="8"></td>

                        <td style="background-color:#3fb618;">${14}</td>

                    </tr>

                </tfoot>

            </table>

        </div>

    </div>


    <div class="clearfix">&nbsp;</div>

    <div class="clearfix">&nbsp;</div>

    <div class="clearfix">&nbsp;</div>


    <div class="col-lg-12" id="payment-summary">

        <div class="panel panel-default">

            <div class="panel-body">


                <div class="row">

                    <div class="col-lg-6">

                                <table class="table table-responsive table-bordered table-striped table-last-col-right">

                                    <caption>Payment Calculation</caption>

                                    <thead>

                                        <tr>

                                            <th> </th>

                                            <th>Name</th>

                                            <th>Age</th>

                                            <th>Fee</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        {15}

                                    </tbody>

                                    <tfoot>

                                        <tr>

                                            <td colspan="3"></td>
                                            <td>

                                                TOTAL PAYABLE: <span class="label label-success label-summary-total">${16}</span>

                                            </td>

                                        </tr>

                                    </tfoot>

                                </table>

                    </div>



                    <div class="col-lg-6 text-left">

                        <table class="table table-responsive table-bordered table-striped" style="margin-bottom:10px">

                            <caption>Bank Details</caption>

                            <thead>

                                <tr>

                                    <th>Please make all payments to the following Bank Details.</th>

                                </tr>

                            </thead>

                        </table>

                            <div class="alert bank-info">

                                <p>Please include your Main Contact Name and Reference number in the payment.</p>

                                <?php include($_SERVER["DOCUMENT_ROOT"] . "/includes/_bankdetails.php");?>

                            </div>

                    </div>

                </div>

                <!-- PRINT ONLY / VIEW ONLY -->
                <div class="print-only hidden row view-only">

                    <div class="col-md-6 col-lg-6">
                        <table class="table table-responsive table-bordered table-striped" style="margin-bottom:10px">
                            <caption>Airport</caption>
                            <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>                        Bus transfer from and to airport on the 27th and the 31st will be provided. $25 separate fee applies per person (both ways). Please select <b>Airport Transfer</b> when you register.</td>
                                </tr>
                            </tbody>                            
                        </table>


                        <div>&nbsp;</div>
                    </div>                    



                    <div class="col-md-6 col-lg-6">
                        <table class="table table-responsive table-bordered table-striped" style="margin-bottom:10px; display: none">
                            <caption>Accomodation</caption>
                            <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>test</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>


                <div class="clearfix">&nbsp;</div>

            </div>



            <div class="panel-footer text-center">

                <button type="button" class="btn btn-primary no-print" onclick="SUBMISSION.submitRegistration(this)" 

                        id="process-rego-button" 

                        data-loading-text="&lt;i class=&#39;fa fa-circle-o-notch fa-spin&#39;&gt;&lt;/i&gt; Processing, please wait...">

                    REGISTER ME !

                </button>

                <button type="button" class="btn btn-default no-print" onclick="swapRegoSummary();">CANCEL</button>

            </div>


        </div>

    </div>

</div>