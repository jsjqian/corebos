<?php 
 /*************************************************************************************************
 * Copyright 2016 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Customizations.
 * Licensed under the vtiger CRM Public License Version 1.1 (the "License"); you may not use this
 * file except in compliance with the License. You can redistribute it and/or modify it
 * under the terms of the License. JPL TSolucio, S.L. reserves all rights not expressly
 * granted by the License. coreBOS distributed by JPL TSolucio S.L. is distributed in
 * the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. Unless required by
 * applicable law or agreed to in writing, software distributed under the License is
 * distributed on an "AS IS" BASIS, WITHOUT ANY WARRANTIES OR CONDITIONS OF ANY KIND,
 * either express or implied. See the License for the specific language governing
 * permissions and limitations under the License. You may obtain a copy of the License
 * at <http://corebos.org/documentation/doku.php?id=en:devel:vpl11>
 *************************************************************************************************
 *  Module       : Business Mappings:: FieldDependency
 *  Version      : 5.4.0
 *  Author       : JPL TSolucio, S. L.
 *************************************************************************************************
 * The accepted format is:
<map> 
  <name>mymap</name> 
  <targetmodule> 
   <targetid>6</targetid> 
   <targetname>Accounts</targetname> 
  </targetmodule> 
  <originmodule> 
   <originid>6</originid> 
   <originname>Accounts</originname> 
  </originmodule> 
  <fields>
   <field>
    <Orgfields> 
     <Responsiblefield> 
      <fieldname>obbietivochiamata</fieldname> 
      <fieldvalue>Welcome Call</fieldvalue> 
      <comparison>equal</comparison>
     </Responsiblefield> 
     .............
     <Orgfield> 
      <fieldname>metodopagamento</fieldname> 
      <fieldaction>show/hide/readonly</fieldaction> 
      <fieldvalue></fieldvalue> 
      <mandatory>mandatory</mandatory>
     </Orgfield> 
     <ResponsibleMode> 
      <values>DetailView</values>
     .............
     </ResponsibleMode>
     <ResponsibleRole> 
      <values>H16</values> 
     .............
     </ResponsibleRole>
     .............
     <Picklist> 
      <fieldname>status</fieldname> 
      <values>OK</values>
      <values>KO</values>
     .............
     </Picklist>
     .............
    </Orgfields> 
   </field>
  </fields> 
</map>
 *************************************************************************************************/

require_once('modules/cbMap/cbMap.php');
require_once('modules/cbMap/processmap/processMap.php');

class FieldDependency extends processcbMap {
	private $mapping = array();
	private $input = array();
	private $output = array();

	function processMap($arguments) {
		$this->convertMap2Array();
		return $this;
	}

	public function getCompleteMapping() {
		return $this->mapping;
	}

	public function readResponsibleField(){
		if(isset($this->mapping["fields"]['field']["Orgfields"]['Responsiblefield']))
			return $this->mapping["fields"]['field']["Orgfields"]['Responsiblefield'];
		return array();
	}

	public function readOrgfield(){
            if(isset($this->mapping["fields"]['field']["Orgfields"]['Orgfield']))
			return $this->mapping["fields"]['field']["Orgfields"]['Orgfield'];
		return array();
	}

        public function readPicklist(){
            if(isset($this->mapping["fields"]['field']["Orgfields"]['Picklist']))
			return $this->mapping["fields"]['field']["Orgfields"]['Picklist'];
		return array();
	}
        
        public function getMapTargetModule(){
            if(isset($this->mapping["targetmodule"]))
			return $this->mapping["targetmodule"];
		return array();
	}
        
        public function getMapOriginModule(){
            if(isset($this->mapping["originmodule"]))
			return $this->mapping["originmodule"];
		return array();
	}
        
	private function convertMap2Array() {
		$xml = $this->getXMLContent();
		$mapping=array();
		$mapping['name'] = $xml->name;
                $mapping['targetmodule']=array();
                $mapping['targetmodule']['targetid']=$xml->targetmodule->targetid;
                $mapping['targetmodule']['targetname']=$xml->targetmodule->targetname;
                $mapping['originmodule']=array();
                $mapping['originmodule']['originid']=$xml->originmodule->originid;
                $mapping['originmodule']['originname']=$xml->originmodule->originname;
                $mapping['fields']=array();
                $mapping['fields']['Responsiblefield']=array();
                foreach ($xml->fields->field->Orgfields->Responsiblefield as $k => $v) {
                $fieldname= isset($v->fieldname) ? (String)$v->fieldname : '';
                $fieldvalue= isset($v->fieldvalue) ? (String)$v->fieldvalue : '';
                $comparison= isset($v->comparison) ? (String)$v->comparison : '';
                $fieldinfo[]=array("fieldname"=>$fieldname,"fieldvalue"=>$fieldvalue,"comparison"=>$comparison);
                }
                $mapping['fields']['Responsiblefield']=$fieldinfo;
                $mapping['fields']['Orgfield']=array();
                foreach ($xml->fields->field->Orgfields->Orgfield as $k2 => $v2) {
                $fieldnameout= isset($v2->fieldname) ? (String)$v2->fieldname : '';
                $fieldaction= isset($v2->fieldaction) ? (String)$v2->fieldaction : '';
                $fieldvalue= isset($v2->fieldvalue) ? (String)$v2->fieldvalue : '';
                $mandatory= isset($v2->mandatory) ? (String)$v2->mandatory : '';
                $fieldinfoorg[]=array("fieldname"=>$fieldnameout,
                "fieldaction"=>$fieldaction,"fieldvalue"=>$fieldvalue,"mandatory"=>$mandatory);
                }
                $mapping['fields']['Orgfield']=$fieldinfoorg;
                $mapping['fields']['ResponsibleMode']=array();
                foreach ($xml->fields->field->Orgfields->ResponsibleMode->values as $k3 => $v3) {
                $responsiblemode[]= isset($v3) ? (String)$v3 : '';
                }   
                $mapping['fields']['ResponsibleMode']=$responsiblemode;
                $mapping['fields']['ResponsibleRole']=array();
                foreach ($xml->fields->field->Orgfields->ResponsibleRole->values as $k4 => $v4) {
                $responsiblerole[]= isset($v4) ? (String)$v4 : '';
                }   
                $mapping['fields']['ResponsibleRole']=$responsiblerole;
                $mapping['fields']['Picklist']=array();
                foreach ($xml->fields->field->Orgfields->Picklist as $k5 => $v5) {
                $value=array();
                $fieldnamepick= isset($v5->fieldname) ? (String)$v5->fieldname : '';
                if(isset($v5->values))
                {
                foreach ($v5->values as $k6 => $v6) {
                $value[]= isset($v6) ? (String)$v6 : '';
                }   
                }
                else $value=array();
                $fieldinfopick[]=array("fieldname"=>$fieldnamepick,"value"=>$value);
                }
                $mapping['fields']['Picklist']=$fieldinfopick;
		$this->mapping = $mapping;
	}

}

?>