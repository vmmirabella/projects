using System.Collections;
using System.Collections.Generic;
using UnityEngine;

[System.Serializable]
public class Attack : BaseAbility
{
    public Attack()
    {
        AbilityName = "Normal Attack";
        AbilityDescription = "A normal attack";
        AbilityID = 1;
        AbilityPower = 10;
        AbilityCost = 5;
    }
}
