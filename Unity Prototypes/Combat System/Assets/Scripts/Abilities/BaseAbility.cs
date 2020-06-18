using System.Collections;
using System.Collections.Generic;
using UnityEngine;

[System.Serializable]
public class BaseAbility 
{
    private string abilityName;
    private string abilityDescription;
    private int abilityID;
    private int abilityPower;
    private int abilityCost;
   // private BaseStatusEffect abilityStatusEffect; //singular status effect on an ability
    private List<BaseStatusEffect> abilityStatusEffects = new List<BaseStatusEffect>(); //multiple status effects

    public string AbilityName { get => abilityName; set => abilityName = value; }
    public string AbilityDescription { get => abilityDescription; set => abilityDescription = value; }
    public int AbilityID { get => abilityID; set => abilityID = value; }
    public int AbilityPower { get => abilityPower; set => abilityPower = value; }
    public int AbilityCost { get => abilityCost; set => abilityCost = value; }
   // public BaseStatusEffect AbilityStatusEffect { get => abilityStatusEffect; set => abilityStatusEffect = value; }
    public List<BaseStatusEffect> AbilityStatusEffects { get => abilityStatusEffects; set => abilityStatusEffects = value; }
}
