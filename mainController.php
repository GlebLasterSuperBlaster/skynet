<?php
    include "db.php";


class mainController
    {
        function runAction()
        {
            $db = new db();
            $connection = $db->getConnection();
            $_SESSION['userId'] = $_POST['userId'];
            $userId = $_SESSION['userId'];
            $selectAll = [];
            $tarifGroupId = "";
            /**
             * $addUserId add User id
             * $addServiseId  add Servise id
             */
            $addUserId = 6;
            $addServiseId = 7;


            function tarifGroupId ($selectAll){
                $idTarif = $selectAll[0]['tarif_group_id'];
                return $idTarif;
            }

            if (!empty($userId)) {
               $selectAll = $db->selectAllTarifs($userId);
            }
            if (!empty($selectAll)) {
                $tarifGroupId = tarifGroupId($selectAll);
                $this->arrAddText($selectAll);
            } else{var_dump(json_encode(["result" => "error"]));}


                        if ( !empty($tarifGroupId)){

                            $insertServices = $db->insertServise($addServiseId ,$addUserId, $tarifGroupId);
                            var_dump(json_encode(["result" => "ok"]));
                        } else {
                            var_dump(json_encode(["result" => "error"]));
                        }
        }

        private function arrAddText(array $selectAll)
        {
            $arr = $selectAll;
            array_unshift($arr, ["result" => "ok"]);
            array_splice($arr, 1,0, ["tarifs :"]);
            var_dump(json_encode($arr, JSON_UNESCAPED_UNICODE));
        }

    }
