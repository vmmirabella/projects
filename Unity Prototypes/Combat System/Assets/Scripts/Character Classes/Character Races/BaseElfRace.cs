using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class BaseElfRace : BaseCharacterRace
{
    public BaseElfRace()
    {
        RaceName = "Elf";
        RaceDescription = "Is a Elf";
        HasStaminaBonus = true;
        HasEnduranceBonus = true;
        HasOverpowerBonus= true;
    }
}
