using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class BaseCharacterRace
{
    private string raceName = "Needs a Name";
    private string raceDescription = "Needs a Description";
    private bool hasStrengthBonus = false;
    private bool hasIntellectBonus = false;
    private bool hasStaminaBonus = false;
    private bool hasEnduranceBonus = false;
    private bool hasOverpowerBonus = false;
    private bool hasLuckBonus = false;
    private bool hasMasteryBonus = false;
    private bool hasCharismaBonus = false;

    public string RaceName { get => raceName; set => raceName = value; }
    public bool HasStrengthBonus { get => hasStrengthBonus; set => hasStrengthBonus = value; }
    public bool HasIntellectBonus { get => hasIntellectBonus; set => hasIntellectBonus = value; }
    public bool HasStaminaBonus { get => hasStaminaBonus; set => hasStaminaBonus = value; }
    public bool HasEnduranceBonus { get => hasEnduranceBonus; set => hasEnduranceBonus = value; }
    public bool HasOverpowerBonus { get => hasOverpowerBonus; set => hasOverpowerBonus = value; }
    public bool HasLuckBonus { get => hasLuckBonus; set => hasLuckBonus = value; }
    public bool HasMasteryBonus { get => hasMasteryBonus; set => hasMasteryBonus = value; }
    public bool HasCharismaBonus { get => hasCharismaBonus; set => hasCharismaBonus = value; }
    public string RaceDescription { get => raceDescription; set => raceDescription = value; }
}
