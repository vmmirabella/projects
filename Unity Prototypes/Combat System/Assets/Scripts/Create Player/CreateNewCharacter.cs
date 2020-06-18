using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class CreateNewCharacter : MonoBehaviour
{
    private BasePlayer newPlayer;
    private bool isMageClass;
    private bool isWarriorClass;
    private string playerName = "Enter name";

    // Start is called before the first frame update
    void Start()
    {
        newPlayer = new BasePlayer();   
    }

    // Update is called once per frame
    void Update()
    {
       
    }

    private void OnGUI()
    {
        //gui element for the user to input a custom name. The name will have a limit of 15 characters
        playerName = GUILayout.TextArea(playerName, 15);

        isMageClass = GUILayout.Toggle(isMageClass, "Mage Class");
        isWarriorClass = GUILayout.Toggle(isWarriorClass, "Warrior Class");

        if (GUILayout.Button("Create"))
        {
            if (isMageClass)
            {
                newPlayer.PlayerClass = new BaseMageClass();
            }
            else if (isWarriorClass)
            {
                newPlayer.PlayerClass = new BaseWarriorClass();
            }


            CreateNewPlayer();
            StoreNewPlayerInfo();
            SaveInformation.SaveAllInformation();

           
        }

        if (GUILayout.Button("Load"))
        {
            SceneManager.LoadScene("test");           
        }

    }

    //save the newly created character to the gameinformation object
    private void StoreNewPlayerInfo()
    {
        GameInformation.PlayerName = newPlayer.PlayerName;
        GameInformation.PlayerLevel = newPlayer.PlayerLevel;
        GameInformation.Stamina = newPlayer.Stamina;
        GameInformation.Endurance = newPlayer.Endurance;
        GameInformation.Intellect = newPlayer.Intellect;
        GameInformation.Strength = newPlayer.Strength;
        GameInformation.Overpower = newPlayer.Overpower;
        GameInformation.Luck = newPlayer.Luck;
        GameInformation.Mastery = newPlayer.Mastery;
        GameInformation.Charisma = newPlayer.Charisma;
        GameInformation.Gold = newPlayer.Gold;
    }

    //Creates a new character with their level 1 stats according to their class
    private void CreateNewPlayer()
    {
        newPlayer.PlayerLevel = 1;
        newPlayer.Stamina = newPlayer.PlayerClass.Stamina;
        newPlayer.Endurance = newPlayer.PlayerClass.Endurance;
        newPlayer.Intellect = newPlayer.PlayerClass.Intellect;
        newPlayer.Strength = newPlayer.PlayerClass.Strength;
        newPlayer.Overpower = newPlayer.PlayerClass.Overpower;
        newPlayer.Luck = newPlayer.PlayerClass.Luck;
        newPlayer.Mastery = newPlayer.PlayerClass.Mastery;
        newPlayer.Charisma = newPlayer.PlayerClass.Charisma;
        newPlayer.Gold = 10;
        newPlayer.PlayerName = playerName;

        Debug.Log("Player Name: " + newPlayer.PlayerName);
        Debug.Log("Player Class: " + newPlayer.PlayerClass.ClassName);
        Debug.Log("Player Level: " + newPlayer.PlayerLevel);
        Debug.Log("Player Stamina: " + newPlayer.Stamina);
        Debug.Log("Player Endurance: " + newPlayer.Endurance);
        Debug.Log("Player Intellect: " + newPlayer.Intellect);
        Debug.Log("Player Strength: " + newPlayer.Strength);
        Debug.Log("Player Overpower: " + newPlayer.Overpower);
        Debug.Log("Player Luck: " + newPlayer.Luck);
        Debug.Log("Player Mastery: " + newPlayer.Mastery);
        Debug.Log("Player Charisma: " + newPlayer.Charisma);

    }
}
