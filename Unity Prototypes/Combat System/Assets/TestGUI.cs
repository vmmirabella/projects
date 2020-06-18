using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class NewBehaviourScript : MonoBehaviour
{

    private BaseCharacterClass class1 = new BaseMageClass();
    private BaseCharacterClass class2 = new BaseWarriorClass();
    // Start is called before the first frame update
    void Start()
    {
        
    }

    // Update is called once per frame
    void Update()
    {
        
    }

    private void OnGUI()
    {
        GUILayout.Label(class1.ClassName);
        GUILayout.Label(class1.ClassDescription);
        GUILayout.Label(class2.ClassName);
        GUILayout.Label(class2.ClassDescription);
    }
}
