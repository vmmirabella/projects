using System.Collections;
using System.Collections.Generic;
using UnityEngine;

[System.Serializable]
public class SleepStatusEffect : BaseStatusEffect
{
    public SleepStatusEffect()
    {
        StatusEffectName = "Sleep";
        StatusEffectDescription = "Sleeps enemy for a number of turns";
        StatusEffectID = 2;
        StatusEffectPower = 0; // base power
        StatusEffectApplyPercentage = 100; // 100% chance of being applied
        StatusEffectStayAppliedPercentage = 25;
        StatusEffectMinTurnApplied = 1;
        StatusEffectMaxTurnApplied = 3;
    }
}
