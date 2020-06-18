using System.Collections;
using System.Collections.Generic;
using UnityEngine;

//inherits from BaseWeapon -> BaseStatItem -> BaseItem
//properties unique to weapons
public class BaseWeapon : BaseStatItem
{
    public enum WeaponTypes
    {
        SWORD,
        STAFF,
        DAGGER,
        BOW,
        SHIELD,
        POLEARM
    }

    private WeaponTypes weaponType;
    private int spellEffectID;

    public WeaponTypes WeaponType { get => weaponType; set => weaponType = value; }
    public int SpellEffectID { get => spellEffectID; set => spellEffectID = value; }
}
