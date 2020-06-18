using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class BaseRogueClass : BaseCharacterClass
{
    public BaseRogueClass()
    {
        ClassName = "Rogue";
        ClassDescription = " A Rogue";
        MainStat = MainStatBonuses.STRENGTH;
        SecondMainStat = SecondStatBonuses.ENDURANCE;
        BonusStat = BonusStatBonuses.OVERPOWER;
        CharacterClass = CharacterClasses.ROGUE;
    }
}
