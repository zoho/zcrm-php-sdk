<?php
/**
 * 
 * @author sumanth-3058
 *
 */
class ZCRMUserTheme
{
	
	private $normalTabFontColor=null;
	private $normalTabBackground=null;
	private $selectedTabFontColor=null;
	private $selectedTabBackground=null;
	private function __construct()
	{
		
	}
	
	public static function getInstance()
	{
		return new ZCRMUserTheme();
	}
	
	

    /**
     * normalTabFontColor
     * @return String
     */
    public function getNormalTabFontColor(){
        return $this->normalTabFontColor;
    }

    /**
     * normalTabFontColor
     * @param String $normalTabFontColor
     */
    public function setNormalTabFontColor($normalTabFontColor){
        $this->normalTabFontColor = $normalTabFontColor;
    }

    /**
     * normalTabBackground
     * @return String
     */
    public function getNormalTabBackground(){
        return $this->normalTabBackground;
    }

    /**
     * normalTabBackground
     * @param String $normalTabBackground
     */
    public function setNormalTabBackground($normalTabBackground){
        $this->normalTabBackground = $normalTabBackground;
    }

    /**
     * selectedTabFontColor
     * @return String
     */
    public function getSelectedTabFontColor(){
        return $this->selectedTabFontColor;
    }

    /**
     * selectedTabFontColor
     * @param String $selectedTabFontColor
     */
    public function setSelectedTabFontColor($selectedTabFontColor){
        $this->selectedTabFontColor = $selectedTabFontColor;
    }

    /**
     * selectedTabBackground
     * @return String
     */
    public function getSelectedTabBackground(){
        return $this->selectedTabBackground;
    }

    /**
     * selectedTabBackground
     * @param String $selectedTabBackground
     */
    public function setSelectedTabBackground($selectedTabBackground){
        $this->selectedTabBackground = $selectedTabBackground;
    }

}
?>