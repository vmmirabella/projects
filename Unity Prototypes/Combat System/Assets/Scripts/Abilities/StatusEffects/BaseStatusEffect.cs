using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class BaseStatusEffect 
{
    private string statusEffectName;
    private string statusEffectDescription;
    private int statusEffectID;
    private int statusEffectPower;
    private int statusEffectApplyPercentage;
    private int statusEffectMaxTurnApplied;
    private int statusEffectMinTurnApplied;
    private int statusEffectStayAppliedPercentage;

    public string StatusEffectName { get => statusEffectName; set => statusEffectName = value; }
    public string StatusEffectDescription { get => statusEffectDescription; set => statusEffectDescription = value; }
    public int StatusEffectID { get => statusEffectID; set => statusEffectID = value; }
    public int StatusEffectPower { get => statusEffectPower; set => statusEffectPower = value; }
    public int StatusEffectApplyPercentage { get => statusEffectApplyPercentage; set => statusEffectApplyPercentage = value; }
    public int StatusEffectMaxTurnApplied { get => statusEffectMaxTurnApplied; set => statusEffectMaxTurnApplied = value; }
    public int StatusEffectMinTurnApplied { get => statusEffectMinTurnApplied; set => statusEffectMinTurnApplied = value; }
    public int StatusEffectStayAppliedPercentage { get => statusEffectStayAppliedPercentage; set => statusEffectStayAppliedPercentage = value; }
}
