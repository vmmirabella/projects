using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class PlayerMovement : MonoBehaviour
{

    public float moveSpeed = 10.0f;
    public float rotateSpeed = 5.0f;

    // Start is called before the first frame update
    void Start()
    {
        
    }

    // Update is called once per frame
    void Update()
    {
        if (Input.GetButtonDown("Fire1"))
        {
            Debug.Log("Pressing Fire1 key");
            Debug.Log("Pressing Fire1 key");
        }


        //moving forward, back, right and left
        if (Input.GetKey("w"))
        {
            transform.Translate((Vector3.forward)* moveSpeed * Time.deltaTime);
            Debug.Log("Pressing w key");
        }
        if (Input.GetKey("s"))
        {
            transform.Translate((Vector3.back) * moveSpeed * Time.deltaTime);
            Debug.Log("Pressing s key");
        }
        if (Input.GetKey("d"))
        {
            transform.Translate((Vector3.right) * moveSpeed * Time.deltaTime);
            Debug.Log("Pressing d key");
        }
        if (Input.GetKey("a"))
        {
            transform.Translate((Vector3.left) * moveSpeed * Time.deltaTime);
            Debug.Log("Pressing a key");
        }

        //rotate
        if (Input.GetKey("q"))
        {
            transform.Rotate((Vector3.down) * rotateSpeed);
            Debug.Log("Pressing q key");
        }
        if (Input.GetKey("e"))
        {
            transform.Rotate((Vector3.up) * rotateSpeed);
            Debug.Log("Pressing e key");
        }





        if (Input.GetMouseButton(1)) //right mouse button
        {
            Debug.Log("Mouse Button Right");
        }
        if (Input.GetMouseButton(0)) //left mouse button
        {
            Debug.Log("Mouse Button Left");
        }


    }
}
