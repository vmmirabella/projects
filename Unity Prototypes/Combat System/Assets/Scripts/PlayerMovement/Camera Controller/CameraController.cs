using System.Collections;
using System.Collections.Generic;
using UnityEngine;

//mostly 3rd person camera
public class CameraController : MonoBehaviour
{

    public Transform cameraTarget;
    private float x = 0.0f;
    private float y = 0.0f;

    private int mouseXSpeedMod = 5;
    private int mouseYSpeedMod = 3;

    //public initally to find the values easier -> transition into making them private
    public float maxViewDistance = 25; // how far the camera will zoom out
    public float minViewDistance = 1; // how close the camera will zoom in
    public int zoomRate = 55; // how fast the camera will zoom

    public float cameraTargetHeight = 1.5f;

    private int lerpRate = 5;
    private float distance = 3; // starting distance away from player
    private float desiredDistance; // used for calculations
    private float correctedDistance; // used for calculations
    private float currentDistance;
    

    // Start is called before the first frame update
    void Start()
    {
        Vector3 angles = transform.eulerAngles;//
        x = angles.x;
        y = angles.y;


        currentDistance = distance;
        desiredDistance = distance;
        correctedDistance = distance;        
    }

    //updates AFTER update function, since camera controls are less important than movement, movement should occur first
    void LateUpdate()
    {
        if (Input.GetMouseButton(0))// 0- left mouse button or 1- right mouse button
        {
           x+= Input.GetAxis("Mouse X")* mouseXSpeedMod;
           y-= Input.GetAxis("Mouse Y") * mouseYSpeedMod;
        }
        else if (Input.GetAxis("Vertical") != 0 || Input.GetAxis("Horizontal") != 0) // if vertical or horizontal buttons are pressed than the code below will execute (slowly rotate behind the player)
        {
            float targetRotationAngle = cameraTarget.eulerAngles.y;
            float cameraRotationAngle = transform.eulerAngles.y;

            //enables the camera to slowly reset behind the player (depending on lerpRate) when the player moves forward ir backwards
            x = Mathf.LerpAngle(cameraRotationAngle, targetRotationAngle, lerpRate * Time.deltaTime);
        }


        y = ClampAngle(y, -50, 80);

        Quaternion rotation = Quaternion.Euler(y, x, 0);


        desiredDistance -= Input.GetAxis("Mouse ScrollWheel") * Time.deltaTime * zoomRate * Mathf.Abs(desiredDistance); //calculate the distance the player wants their camera
        desiredDistance = Mathf.Clamp(desiredDistance, minViewDistance, maxViewDistance); // makes sure the player is unable to go past these set values (clamping)
        correctedDistance = desiredDistance;

        Vector3 position = cameraTarget.position - (rotation * Vector3.forward * desiredDistance); //(x,y,z) * (0,1,0) * (angle in degrees) - vector cross multiplying -> updated position of where camera should be 
        
        transform.rotation = rotation; // when you call transform within the script, the script looks for the transform the script is attached to
        transform.position = position;


        //camera collision - avoid the camera from clipping into terrian and/or going under it

        RaycastHit collisionHit;
        Vector3 cameraTargetPosition = new Vector3(cameraTarget.position.x, cameraTarget.position.y + cameraTargetHeight, cameraTarget.position.z);

        bool isCorrected = false;
        if(Physics.Linecast(cameraTarget.position, position, out collisionHit))
        {
            position = collisionHit.point;
            correctedDistance = Vector3.Distance(cameraTargetPosition, position);
            isCorrected = true;
        }

        currentDistance = !isCorrected || correctedDistance > currentDistance ? Mathf.Lerp(currentDistance, correctedDistance, Time.deltaTime * zoomRate) : correctedDistance;

        position = cameraTarget.position - (rotation * Vector3.forward * currentDistance + new Vector3(0, -cameraTargetHeight, 0)); // calculate position again


    }

    private static float ClampAngle(float angle, float min, float max)
    {
        if (angle < -360)
        {
            angle += 360;
        }

        if (angle > 360)
        {
            angle -= 360;
        }
        return Mathf.Clamp(angle, min, max);
    }

}
