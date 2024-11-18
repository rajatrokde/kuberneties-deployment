# AWS EKS Cluster Setup with MySQL and Load Balancer

This repository outlines the steps for setting up an AWS EKS cluster, installing necessary tools, creating a MySQL database, and setting up a Load Balancer to fetch data from MySQL.

## Steps to Set Up the Cluster

### Step 1: Create IAM Users

- Go to the **IAM console** in AWS and create IAM users with the necessary permissions.
- Attach the required policies (e.g., `AmazonEKSClusterPolicy`, `AmazonEKSWorkerNodePolicy`, and `AmazonEC2ContainerRegistryReadOnly`).

### Step 2: Install AWS CLI

Run the following commands to install the AWS CLI:

```bash
curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip"
sudo apt install unzip
unzip awscliv2.zip
sudo ./aws/install -i /usr/local/aws-cli -b /usr/local/bin --update
aws configure
```

When running aws configure, provide the following details:

  - Access Key
  - Secret Key
  - Region (e.g., us-east-1)
  - Output format (json)

### Step 3: Install kubectl

Install kubectl using the following commands:

```bash
curl -o kubectl https://amazon-eks.s3.us-west-2.amazonaws.com/1.19.6/2021-01-05/bin/linux/amd64/kubectl
chmod +x ./kubectl
sudo mv ./kubectl /usr/local/bin
kubectl version --short --client
```

### Step 4: Install eksctl

To install eksctl, run:

```bash
curl --silent --location "https://github.com/weaveworks/eksctl/releases/latest/download/eksctl_$(uname -s)_amd64.tar.gz" | tar xz -C /tmp
sudo mv /tmp/eksctl /usr/local/bin
eksctl version
```

### Step 5: Create the Cluster

Create the EKS cluster using eksctl:

```bash
eksctl create cluster --name my-cluster --region us-east-1 --node-type t2.medium --nodes-min 2 --nodes-max 4
kubectl get nodes
```

### Step 6: Delete Cluster (Optional)

If you wish to delete the cluster, run the following command:

```bash
eksctl delete cluster --name my-cluster --region us-east-1
```


## Deploying Applications on Kubernetes

After the cluster is created, deploy the necessary resources.


### Step 1: Clone the Repository
Clone your repository which contains your Kubernetes configuration files.

```bash
git clone https://github.com/chiragpuniyanii/AWS-EKS-Cluster-Setup-with-MySQL-and-Load-Balancer.git
cd AWS-EKS-Cluster-Setup-with-MySQL-and-Load-Balancer
```

### Step 2: Apply php.yaml and db.yaml

Run the following commands to deploy your PHP application and MySQL database:

```bash
kubectl apply -f php.yaml
kubectl get svc
kubectl apply -f db.yaml
kubectl get svc
```

```bash
kubectl get pods
```

### Step 3: Access MySQL and Create Database
To login to MySQL:

```bash
kubectl exec -it <mysql-pod-name> -- bash
mysql -u root -p
```
Enter the password chirag when prompted.

Once logged in, create your database and table:

```sql
USE my_database;
CREATE TABLE cute_table (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);
```

### Step 4: Set Up Load Balancer
Now, set up the Load Balancer to fetch data from the MySQL database:

Ensure the Load Balancer is properly configured.
Add data to your cute_table in MySQL.
Verify that data is being fetched properly through the Load Balancer.

### Step 5: Verify Data Fetch
After adding data to your database, verify that it is being fetched by the Load Balancer correctly.

## Conclusion
You have now successfully created an AWS EKS cluster, deployed your PHP and MySQL applications, and configured a Load Balancer to fetch data from the database.

For any issues or questions, feel free to open an issue in this repository or contact me directly.

## About
Created by **Rajat Rokde **

GitHub: **Rajatrokde**

Email: Rajatrokde01@gmail.com


This README follows the structure of the steps you provided, ensuring each phase of the setup and deployment 
