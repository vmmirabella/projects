using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class BattleCalculations 
{
    private StatCalculations statCalcScript = new StatCalculations();

    private int abilityPower;
    private float totalAbilityPowerDamage;
    private int totalUsedAbilityDamage;

  public void CalculateUsedPlayerAbilityDamage(BaseAbility usedAbility)
    {
        //ability damage + critical strike + armor reduction + stats + weapon damage + status effect
        totalUsedAbilityDamage = (int)CalculateAbilityDamage(usedAbility);
        //use an ability
        //calculate damage
        //check status effect


    }

    private float CalculateAbilityDamage(BaseAbility usedAbility)
    {
        totalAbilityPowerDamage = usedAbility.AbilityPower * statCalcScript.FindPlayerMainStatWithMainStatModifier();
        return totalAbilityPowerDamage;
    }
}
