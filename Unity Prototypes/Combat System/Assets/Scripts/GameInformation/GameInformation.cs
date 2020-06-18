using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class GameInformation : MonoBehaviour
{
    private void Awake()
    {
        //makes sure the object isn't deleted on loading. Stays on every scene so the information can be passed to different scenes 
        //**ALL objects, unless stated otherwise, are deleted when a scene is changed**

        DontDestroyOnLoad(transform.gameObject);
    }

  //  private static List<BaseAbility> playerAbilities;

    //stores information to be used throughout the game
    public static string PlayerName { get; set; }
    public static int PlayerLevel { get; set; }
    public static BaseCharacterClass PlayerClass { get; set; }
    public static int Stamina { get; set; }
    public static int Endurance { get; set; }
    public static int Intellect { get; set; }
    public static int Strength { get; set; }
    public static int Overpower { get; set; }
    public static int Luck { get; set; }
    public static int Mastery { get; set; }
    public static int Charisma { get; set; }
    public static int Gold { get; set; }
    public static int CurrentXP { get; set; }
    public static int RequiredXP { get; set; }

    public static BaseEquipment EquipmentOne { get; set; }

    public static bool IsMale { get; set; }
    public static string PlayerBio { get; set; }

    public static int PlayerHealth { get; set; }
    public static int PlayerEnergy { get; set; }

    //hardcode for an easy way to see them, not optimal
    public static BaseAbility playerMoveOne = new Attack();
    public static BaseAbility playerMoveTwo = new SwordSlash();
   
    //public static List<BaseAbility> PlayerAbilities { get => playerAbilities; set => playerAbilities = value; }
}
