using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class BaseArcherClass : BaseCharacterClass
{
    public BaseArcherClass()
    {
        ClassName = "Archer";
        ClassDescription = " An Archer";
        MainStat = MainStatBonuses.INTELLECT;
        SecondMainStat = SecondStatBonuses.STRENGTH;
        BonusStat = BonusStatBonuses.MASTERY;
        CharacterClass = CharacterClasses.ARCHER;

    }
}
