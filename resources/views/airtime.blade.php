@include('layouts.sidebar')
<div class="content-body">
    <div class="container-fluid">


    <div style="padding:90px 15px 20px 15px">
        <h4 class="align-content-center text-sm-center">Airtime TopUp</h4>
        <div class="card">

            <div class="card-body">
                <!--            <div class="box w3-card-4">-->

                <form action="{{route('time')}}" method="post">
                    @csrf
                    <script>
                        $(document).ready(function() {
                            toastr.options.timeOut = 60000;
                            @if (Session::has('error'))
                            toastr.error('{{ Session::get('error') }}');
                            @elseif(Session::has('success'))
                            toastr.success('{{ Session::get('success') }}');
                            @endif
                        });

                    </script>
                    <div class="row">

                        <div class="col-sm-8">
                            <x-auth-validation-errors class="alert-danger text-danger" :errors="$errors" />

                            <br>
                            <br>
                            <div id="AirtimeNote" class="alert alert-danger" style="text-transform: uppercase;font-weight: bold;font-size: 23px;display: none;"></div>
                            <div id="AirtimePanel">

                                <div id="div_id_network" class="form-group">
                                    <label for="network" class=" requiredField">
                                        Network<span class="asteriskField">*</span>
                                    </label>
                                    <div class="">
                                        <select name="id" class="text-success form-control" required="">
                                       <option value="m">MTN</option>
                                       <option value="g">GLO</option>
                                       <option value="a">AIRTEL</option>
                                       <option value="9">9MOBILE</option>
                                        </select>
                                    </div>
                                </div>
                                <label for="network" class=" requiredField">
                                    Phone No<span class="asteriskField">*</span>
                                </label>
                                <input type="number" minlength="11" maxlength="11"  class="form-control"  name="number" required/>

                                <label for="network" class=" requiredField">
                                    Amount<span class="asteriskField">*</span>
                                </label>
                                <input type="number" min="100" max="1000" class="form-control"  name="amount" required/>
                                <input type="hidden"  class="form-control"  name="refid" value="{{rand(11111111, 999999999)}}" required/>

                                <button type="submit" class=" btn" style="color: white;background-color: #095b26" id="btnsubmit"> Purchase Now</button>
                            </div>
                        </div>
                        <div class="col-sm-4 ">
                            <br>
                            <center> <h6>Codes for Airtime Balance: </h6></center>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-primary">MTN Airtime VTU    <span id="RightT"> *556#  </span></li>

                                <li class="list-group-item list-group-item-success"> 9mobile Airtime VTU   *232# </li>
                                <li class="list-group-item list-group-item-action"> Airtel Airtime VTU   *123# </li>
                                <li class="list-group-item list-group-item-info"> Glo Airtime VTU #124#. </li>
                            </ul>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>

                </form>


            </div>


        </div>


        <!-- Datatable -->
        <script src="{{asset('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('js/plugins-init/datatables.init.js')}}"></script>
        <script src="{{asset('js/custom.min.js')}}"></script>
        <script src="{{asset('js/deznav-init.js')}}"></script>
        <script src="{{asset('js/demo.j')}}s"></script>
        <script src="{{asset('js/styleSwitcher.js')}}"></script>
