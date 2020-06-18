using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class BaseHumanRace : BaseCharacterRace
{
    public BaseHumanRace()
    {
        RaceName = "Human";
        RaceDescription = "Is a Human";
        HasStaminaBonus = true;
        HasStrengthBonus = true;
        HasCharismaBonus = true;
    }
}
