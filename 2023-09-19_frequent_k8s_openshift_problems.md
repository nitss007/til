## frequent_k8s_openshift_problems

What are the Errors you have come across while working on Kubernetes?

Below are Some Known Kuberenets errors:

𝐏𝐨𝐝 𝐏𝐞𝐧𝐝𝐢𝐧𝐠: Pods may remain in the "Pending" state if there are insufficient resources, such as CPU or memory, available on the cluster. Check the resource requests and limits for the pod, and ensure that the node has enough capacity.

𝐂𝐫𝐚𝐬𝐡𝐋𝐨𝐨𝐩𝐁𝐚𝐜𝐤𝐎𝐟𝐟: If a pod repeatedly crashes and enters a "CrashLoopBackOff" state, check the container logs using kubectl logs to identify the issue. Common causes include misconfigured application settings or missing dependencies.

𝐈𝐦𝐚𝐠𝐞𝐏𝐮𝐥𝐥𝐁𝐚𝐜𝐤𝐎𝐟𝐟: This error occurs when Kubernetes is unable to pull the container image specified in the pod's manifest. Ensure that the image name and credentials (if needed) are correctly configured. Also, check if there are any issues with the image repository.

𝐍𝐨𝐝𝐞 𝐍𝐨𝐭𝐑𝐞𝐚𝐝𝐲: Nodes in a cluster may become "NotReady" due to various reasons, such as network problems, resource exhaustion, or system issues. Investigate the node's status using kubectl describe node and resolve any underlying problems.

𝐒𝐞𝐫𝐯𝐢𝐜𝐞 𝐔𝐧𝐚𝐯𝐚𝐢𝐥𝐚𝐛𝐥𝐞: If a service is not accessible, ensure that the service and its associated pods are running. Use kubectl get pods and kubectl get services to check their statuses.

𝐏𝐞𝐫𝐬𝐢𝐬𝐭𝐞𝐧𝐭𝐕𝐨𝐥𝐮𝐦𝐞𝐂𝐥𝐚𝐢𝐦 (𝐏𝐕𝐂) 𝐈𝐬𝐬𝐮𝐞𝐬: Problems with PVCs can lead to pod failures. Check the status of PVCs using kubectl get pvc and make sure they are bound to a PersistentVolume (PV). Also, ensure that the PV is available and in the correct state.

𝐑𝐁𝐀𝐂 𝐀𝐮𝐭𝐡𝐨𝐫𝐢𝐳𝐚𝐭𝐢𝐨𝐧 𝐄𝐫𝐫𝐨𝐫𝐬: If you encounter permission errors, it may be related to Role-Based Access Control (RBAC) settings. Ensure that ServiceAccounts, Roles, and RoleBindings are correctly configured.

𝐍𝐞𝐭𝐰𝐨𝐫𝐤 𝐏𝐨𝐥𝐢𝐜𝐢𝐞𝐬: If you have Network Policies in place, misconfigured policies can lead to network-related issues. Verify that your network policies are correctly defined and applied.

𝐒𝐭𝐨𝐫𝐚𝐠𝐞𝐂𝐥𝐚𝐬𝐬 𝐍𝐨𝐭 𝐅𝐨𝐮𝐧𝐝: When using dynamic volume provisioning, make sure that the appropriate StorageClass exists and is accessible. Ensure that the PVC references the correct StorageClass.

𝐑𝐞𝐬𝐨𝐮𝐫𝐜𝐞 𝐐𝐮𝐨𝐭𝐚𝐬 𝐚𝐧𝐝 𝐋𝐢𝐦𝐢𝐭𝐬: Resource quotas and limits can lead to pods being unable to start or scale. Check the resource limits defined for your namespaces and pods.

𝐈𝐧𝐠𝐫𝐞𝐬𝐬 𝐂𝐨𝐧𝐭𝐫𝐨𝐥𝐥𝐞𝐫 𝐈𝐬𝐬𝐮𝐞𝐬: If you're using Ingress controllers for routing traffic to services, errors can occur due to misconfigured Ingress resources. Review your Ingress definitions and ensure they match your cluster setup.

You can find good websites/articles for understanding and troubleshooting these errors in more detail on the internet.

