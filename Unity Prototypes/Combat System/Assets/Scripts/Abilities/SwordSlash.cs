using System.Collections;
using System.Collections.Generic;
using UnityEngine;

[System.Serializable]
public class SwordSlash : BaseAbility
{
    public SwordSlash()
    {
        AbilityName = "Sword Slash";
        AbilityDescription = " Strong sword slash";
        AbilityID = 2;
        AbilityPower = 20;
        AbilityCost = 10;
        AbilityStatusEffects.Add(new BurnStatusEffect());
    }
}
