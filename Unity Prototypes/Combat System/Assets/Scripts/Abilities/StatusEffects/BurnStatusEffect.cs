using System.Collections;
using System.Collections.Generic;
using UnityEngine;

[System.Serializable]
public class BurnStatusEffect : BaseStatusEffect
{
    public BurnStatusEffect()
    {
        StatusEffectName = "Burn";
        StatusEffectDescription = "Burns enemy for a number of turns";
        StatusEffectID = 1;
        StatusEffectPower = 10; // base power
        StatusEffectApplyPercentage = 75; // 75% chance of being applied
        StatusEffectStayAppliedPercentage = 75;
        StatusEffectMinTurnApplied = 2;
        StatusEffectMaxTurnApplied = 6;
    }
}
