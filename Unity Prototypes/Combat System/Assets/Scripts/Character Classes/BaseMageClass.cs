using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class BaseMageClass : BaseCharacterClass
{
  
    public BaseMageClass()
    {
        ClassName = "Mage";
        ClassDescription = " A Mage";
        MainStat = MainStatBonuses.INTELLECT;
        SecondMainStat = SecondStatBonuses.ENDURANCE;
        BonusStat = BonusStatBonuses.LUCK;
        CharacterClass = CharacterClasses.MAGE;
    }

    
}