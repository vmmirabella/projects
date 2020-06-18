using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class BaseGnomeRace : BaseCharacterRace
{
    public BaseGnomeRace()
    {
        RaceName = "Gnome";
        RaceDescription = "Is a Gnome";
        HasIntellectBonus = true;
        HasEnduranceBonus = true;
        HasLuckBonus = true;
    }
}
