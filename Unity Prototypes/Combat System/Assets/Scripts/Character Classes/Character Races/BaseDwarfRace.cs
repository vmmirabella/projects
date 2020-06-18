using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class BaseDwarfRace : BaseCharacterRace
{
    public BaseDwarfRace()
    {
        RaceName = "Dwarf";
        RaceDescription = "Is a Dwarf";
        HasIntellectBonus = true;
        HasStrengthBonus = true;
        HasMasteryBonus = true;
    }
}
