<?php
/**
 * Common methods to every classes
 * @author adriano
 */
Class AbstractModel extends Zend_Db_Table_Abstract{

    public function getHTMLSelect( $idNotSelect = false, $order = ' asc' ){

      $statement = $this->select();
      $id = $this->_primary[1];
      
      if( $idNotSelect ) {
          $where = $id.' <> ?';
          $statement->where( $where , $idNotSelect);
      }
      $statement->order( $id.$order );
      
      $rows = $this->fetchAll( $statement );
      $html = '<select name="'. $this->_name .'">';

      foreach( $rows as $row ){
        $option = '<option value="'. $row[ $id ] .'">'. $row['nome'] .'</option>';
        $html  .= $option;
      }

        $html .= '</select>';
        return $html;
    }

    /**
     * Builds a select tag with a Rowset
     * @param Zend_Db_Table_Rowset_Abstract $rowSet
     * @param string $name the attribute name of select tag
     * @param array the value and text of option tags
     * @return string
     */
    public function mountSelect( Zend_Db_Table_Rowset_Abstract $rowSet, $name, array $fieldNames ){

       $html = '<select name="'.$name.'">';
       foreach ( $rowSet as $row ) {
         $html .= '<option value="'.$row[ $fieldNames[0] ].'">'.$row[ $fieldNames[1] ].'</option>';
       }
       $html .= '</select>';
         return $html;
    }
}
?>
