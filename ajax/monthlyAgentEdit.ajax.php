<?php
require_once "../controllers/pensioner.controller.php";
require_once "../models/pensioner.model.php";
require_once "../views/modules/session.php";

$id = $_GET['id'];


$editMonthly = new MonthlyAgentModal();
$editMonthly->monthlyAgentEditModal();


class MonthlyAgentModal{

    public function monthlyAgentEditModal(){
        $id = $_GET['id'];
        $data = (new ControllerPensioner)->ctrshowMonthlyAgentEdit($id);
        foreach ($data as &$item) {
            $mdate = $item['mdate'];
            $agents = $item['agents'];
            $sales = $item['sales'];

            $item['card'] ='


            <div class="row mb-4">
            <div class="col-sm-6 form-group">
                <label for="input-6">DATE</label>
                <input type="date" class="form-control" id="mdate" value="'.$mdate.'" placeholder="Enter Date" name="mdate" autocomplete="nope" required>
                <input type="text"  hidden class="form-control" id="id"  name="id" value="'.$id.'" autocomplete="nope">
            </div> 
            </div>

            <div class="row">
            <div class="col-sm-6 form-group">
                <label for="input-12">AGENTS</label>
                <input type="number" class="form-control" value="'.$agents.'" placeholder="Enter Agent"  id="agents" name="agents" >
            </div>
         

         
            <div class="col-sm-6 form-group">
            <label for="input-12">SALES</label>
            <input type="number" class="form-control" value="'.$sales.'" placeholder="Enter Sales"  id="sales" name="sales" >
            </div>
         
            </div>

            <div class="modal-footer">
                    <button type="submit" name ="editMonthlydata" id="editMonthlydata" class="btn btn-primary">Submit</button>
                    <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

            ';
            
        }
       echo json_encode($data);
       // echo json_encode(['card' => $data]);
    }

}