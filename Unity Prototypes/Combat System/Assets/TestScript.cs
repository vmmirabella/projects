using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class TestScript : MonoBehaviour
{
    // Start is called before the first frame update
    void Start()
    {
        LoadInformation.LoadAllInformation();

        Debug.Log("Player Name: " + GameInformation.PlayerName);
        //Debug.Log("Player Class: " + GameInformation.ClassName);
        Debug.Log("Player Level: " + GameInformation.PlayerLevel);
        Debug.Log("Player Stamina: " + GameInformation.Stamina);
        Debug.Log("Player Endurance: " + GameInformation.Endurance);
        Debug.Log("Player Intellect: " + GameInformation.Intellect);
        Debug.Log("Player Strength: " + GameInformation.Strength);
        Debug.Log("Player OVERPOWER: " + GameInformation.Overpower);
        Debug.Log("Player LUCK: " + GameInformation.Luck);
        Debug.Log("Player Gold: " + GameInformation.Gold);

    }

    // Update is called once per frame
    void Update()
    {
        
    }
}
