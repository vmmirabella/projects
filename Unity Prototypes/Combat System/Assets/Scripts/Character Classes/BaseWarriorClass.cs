using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class BaseWarriorClass : BaseCharacterClass
{
    public BaseWarriorClass()
    {

        ClassName = "Warrior";
        ClassDescription = " A Warrior";
        MainStat = MainStatBonuses.STRENGTH;
        SecondMainStat = SecondStatBonuses.STAMINA;
        BonusStat = BonusStatBonuses.CHARISMA;
        CharacterClass = CharacterClasses.WARRIOR;
        PlayerAbilties.Add(new Attack());
        PlayerAbilties.Add(new SwordSlash());
    }
}
