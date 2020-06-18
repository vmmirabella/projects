using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class PlayerController : MonoBehaviour
{
    public float rotateSpeed =5.0f;

    public float runSpeed;
    public float forwardSpeed = 5.0f;
    private CharacterController playerController;


    // Start is called before the first frame update
    void Start()
    {
        playerController = GetComponent<CharacterController>();
    }

    // Update is called once per frame
    void Update()
    {
        if (Input.GetKeyDown("space") && playerController.isGrounded)
        {
            playerController.Move(Vector3.up);
        }

        transform.Rotate(0, Input.GetAxis("Horizontal") * rotateSpeed, 0); // Vector 3 = 0,0,0 = x,y,z

        Vector3 forward = transform.TransformDirection(Vector3.forward);

        float speed = forwardSpeed * Input.GetAxis("Vertical");

        playerController.SimpleMove(speed * forward);

        //Edit->Project Settings -> Input -> Right-click on an item such as "Jump" and duplicate array -> Rename to "Run" and change values -> Positive button = button user will use
        if(Input.GetAxis("Run") == 1 && playerController.isGrounded )
        {
            runSpeed = forwardSpeed * 1.5f;
            forwardSpeed = runSpeed;
        }

    }
}
